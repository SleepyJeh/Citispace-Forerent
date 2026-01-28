import joblib
import pandas as pd
from fastapi import FastAPI
from pydantic import BaseModel, Field
from typing import List

# --- 1. Load Model and Define Columns ---
app = FastAPI()

try:
    model_pipeline = joblib.load("dorm_price_model.joblib")
except FileNotFoundError:
    print("Error: dorm_price_model.joblib not found!")
    exit()

# 💡 1. THE FIRST FIX: Add 'Cluster' to this list
# This MUST match the columns your model was trained on
ALL_COLUMNS = [
    'Floor', 'M/F', 'Bed type', 'Room type', 'Room capacity', 'Unit capacity',
    'Cluster',  # <-- THIS IS THE NEWLY ADDED COLUMN
    'Fully_furnished', 'Free_Wifi', 'Hot_Cold_Shower', 'Electric_Fan',
    'Water_Kettle', 'Closet_Cabinet', 'Housekeeping', 'Refrigerator',
    'Microwave', 'Rice_Cooker', 'Dining_Table', 'Utility_Subsidy',
    'AC_Unit', 'Induction_Cooker', 'Washing_Machine', 'Access_Pool',
    'Access_Gym', 'Bunk_Bed_Mattress'
]

# --- 2. Define Input Data Shape ---
# This does NOT change. We are not adding 'Cluster' to the form.
class UnitFeatures(BaseModel):
    Floor: int
    M_F: str = Field(alias='M/F')
    Bed_type: str = Field(alias='Bed type')
    Room_type: str = Field(alias='Room type')
    Room_capacity: int = Field(alias='Room capacity')
    Unit_capacity: int = Field(alias='Unit capacity')
    
    # All 18 Amenities
    Fully_furnished: bool
    Free_Wifi: bool
    Hot_Cold_Shower: bool
    Electric_Fan: bool
    Water_Kettle: bool
    Closet_Cabinet: bool
    Housekeeping: bool
    Refrigerator: bool
    Microwave: bool
    Rice_Cooker: bool
    Dining_Table: bool
    Utility_Subsidy: bool
    AC_Unit: bool
    Induction_Cooker: bool
    Washing_Machine: bool
    Access_Pool: bool
    Access_Gym: bool
    Bunk_Bed_Mattress: bool

# --- 3. Create Prediction Endpoint ---
@app.post("/predict")
def predict_price(features: UnitFeatures):
    
    # 1. Convert input from Laravel to a Python dictionary
    input_data = features.dict(by_alias=True)
    
    # 💡 2. THE SECOND FIX: Add the dummy 'Cluster' value
    # We add this "N/A" value here so the model doesn't crash.
    # The OneHotEncoder will see "handle_unknown='ignore'" and won't crash.
    input_data['Cluster'] = 'N/A'
    
    # 3. Convert the dictionary into a single-row DataFrame
    # This will now have the 'Cluster' column and work correctly
    input_df = pd.DataFrame([input_data], columns=ALL_COLUMNS)
    
    # 4. Make the prediction
    prediction = model_pipeline.predict(input_df)
    
    # 5. Return the result as JSON
    return {"predicted_price": float(prediction[0])}