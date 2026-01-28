# 1. Start from a clean, lightweight Python image
FROM python:3.10-slim

# 2. Set the working directory inside the container
WORKDIR /app

# 3. Copy your requirements file
# This copies 'price_api/requirements.txt' into '/app/requirements.txt'
COPY requirements.txt .

# 4. Install the Python libraries
RUN pip install --no-cache-dir -r requirements.txt

# 5. Copy the rest of your code (main.py, dorm_price_model.joblib)
COPY . .

# 6. Run the Uvicorn server
# This listens on 0.0.0.0 to be reachable by your Laravel container
CMD ["uvicorn", "main:app", "--host", "0.0.0.0", "--port", "8000"]