<aside id="sidebar-multi-level-sidebar"
    class="h-full bg-white"
    aria-label="Sidebar">
    <div class="h-full px-3 py-6 overflow-y-auto flex flex-col">
        <!-- Logo -->
        <a href="#" class="flex items-center justify-center mb-8">
            <img src="{{ asset('images/forerent-logo.svg') }}" alt="ForeRent" class="h-8" />
        </a>

        <!-- Main Navigation -->
        <ul class="space-y-2 font-medium flex-1">
            <li>
                <a href="#"
                    class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-[#DFE8FC] hover:text-[#070642] group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-[#070642]"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 31 32">
                        <rect x="0.015625" y="0.275391" width="14.3854" height="10.2358" rx="2.21314" />
                        <rect x="16.6133" y="21.0234" width="14.3854" height="10.2358" rx="2.21314" />
                        <rect x="16.6133" width="14.3854" height="19.3649" rx="2.21314" />
                        <rect x="0.015625" y="12.1719" width="14.3854" height="19.3649" rx="2.21314" />
                    </svg>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>

            <li>
                <button type="button"
                    class="flex items-center w-full p-3 text-gray-700 rounded-lg hover:bg-[#DFE8FC] hover:text-[#070642] group"
                    aria-controls="properties-dropdown" data-collapse-toggle="properties-dropdown">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-[#070642]"
                        width="29" height="37" viewBox="0 0 29 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 6.47878L9.75082 0.537109V36.1871H0V6.47878Z" fill="currentColor" />
                        <path d="M18.4219 5.93863L10.2962 0.537109V36.1871H18.4219V5.93863Z" fill="currentColor" />
                        <path d="M28.4414 23.8973L18.9614 18.6309V36.1858H28.4414V23.8973Z" fill="currentColor" />
                        <path d="M1.35938 9.37367L4.20336 7.76758V10.362L1.35938 11.8446V9.37367Z" fill="#F4F7FC" />
                        <path d="M5.28516 7.27406L8.12915 5.66797V8.26242L5.28516 9.74496V7.27406Z" fill="#F4F7FC" />
                        <path d="M1.35938 16.0905L4.20336 14.4844V17.0788L1.35938 18.5614V16.0905Z" fill="#F4F7FC" />
                        <path d="M5.28516 13.9909L8.12915 12.3848V14.9792L5.28516 16.4618V13.9909Z" fill="#F4F7FC" />
                        <path d="M1.35938 22.8092L4.20336 21.2031V23.7976L1.35938 25.2801V22.8092Z" fill="#F4F7FC" />
                        <path d="M5.28516 20.7096L8.12915 19.1035V21.698L5.28516 23.1805V20.7096Z" fill="#F4F7FC" />
                        <path d="M1.35938 29.526L4.20336 27.9199V30.5144L1.35938 31.9969V29.526Z" fill="#F4F7FC" />
                        <path d="M5.28516 27.4264L8.12915 25.8203V28.4148L5.28516 29.8973V27.4264Z" fill="#F4F7FC" />
                        <path d="M27.0898 26.6588L24.2459 25.0527V27.6472L27.0898 29.1297V26.6588Z" fill="#F4F7FC" />
                        <path d="M23.1602 24.5592L20.3162 22.9531V25.5476L23.1602 27.0301V24.5592Z" fill="#F4F7FC" />
                        <path d="M27.0898 31.7916L24.2459 30.1855V32.78L27.0898 34.2625V31.7916Z" fill="#F4F7FC" />
                        <path d="M23.1602 29.6901L20.3162 28.084V30.6784L23.1602 32.161V29.6901Z" fill="#F4F7FC" />
                    </svg>
                    <span class="flex-1 ms-3 text-left">Properties</span>
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="properties-dropdown" class="hidden py-2 space-y-2">
                    <li>
                        <a href="/condotel"
                            class="flex items-center w-full p-2 text-gray-700 transition duration-75 rounded-lg pl-11 hover:bg-[#DFE8FC] hover:text-[#070642]">Condotel</a>
                    </li>
                    <li>
                        <a href="/apartment"
                            class="flex items-center w-full p-2 text-gray-700 transition duration-75 rounded-lg pl-11 hover:bg-[#DFE8FC] hover:text-[#070642]">Apartment</a>
                    </li>
                    <li>
                        <a href="/property"
                            class="flex items-center w-full p-2 text-gray-700 transition duration-75 rounded-lg pl-11 hover:bg-[#DFE8FC] hover:text-[#070642]">Dorm</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#"
                    class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-[#DFE8FC] hover:text-[#070642] group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-[#070642]"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 38">
                        <path d="M0.015625 0.262695H23.1005V37.455L19.253 36.1725L15.4056 37.455L11.5581 36.1725L7.71059 37.455L3.86311 36.1725L0.015625 37.455V0.262695Z" />
                        <line x1="2.57812" y1="7.78356" x2="19.8918" y2="7.78356" stroke="#F4F7FC" stroke-width="1.28249" />
                        <line x1="2.57812" y1="14.1966" x2="19.8918" y2="14.1966" stroke="#F4F7FC" stroke-width="1.28249" />
                        <line x1="2.57812" y1="20.6097" x2="19.8918" y2="20.6097" stroke="#F4F7FC" stroke-width="1.28249" />
                    </svg>
                    <span class="ms-3">Payments</span>
                </a>
            </li>

            <li>
    <button type="button"
        class="flex items-center w-full p-3 text-gray-700 rounded-lg hover:bg-[#DFE8FC] hover:text-[#070642] group"
        aria-controls="revenue-dropdown" data-collapse-toggle="revenue-dropdown">
        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-[#070642]"
            width="33" height="34" viewBox="0 0 33 34" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M30.1199 0.890595C30.2275 0.581407 30.0684 0.242565 29.7645 0.133771C29.4606 0.024977 29.1271 0.187428 29.0195 0.496616L29.5697 0.693605L30.1199 0.890595ZM18.7248 16.1548L18.346 15.7041L18.7248 16.1548ZM1.03906 26.1523C1.18067 26.7278 1.18086 26.7278 1.18109 26.7277C1.18121 26.7277 1.18147 26.7276 1.18171 26.7276C1.18219 26.7274 1.1828 26.7273 1.18355 26.7271C1.18504 26.7267 1.18707 26.7262 1.18963 26.7255C1.19474 26.7242 1.20196 26.7223 1.21127 26.7198C1.22988 26.7148 1.25682 26.7076 1.29182 26.6979C1.36182 26.6786 1.46406 26.6496 1.59645 26.6102C1.86121 26.5313 2.24659 26.4108 2.73567 26.242C3.71373 25.9046 5.10718 25.3743 6.78051 24.5998C10.1263 23.0514 14.597 20.5241 19.1037 16.6056L18.7248 16.1548L18.346 15.7041C13.9396 19.5354 9.56746 22.0068 6.29859 23.5197C4.66461 24.2759 3.30782 24.7919 2.36246 25.1181C1.88983 25.2811 1.52021 25.3967 1.2704 25.4711C1.14549 25.5083 1.05056 25.5351 0.987701 25.5525C0.956271 25.5612 0.93286 25.5675 0.917731 25.5715C0.910167 25.5735 0.904673 25.575 0.901283 25.5759C0.899588 25.5763 0.898419 25.5766 0.89778 25.5768C0.897461 25.5769 0.897274 25.5769 0.89722 25.5769C0.897193 25.5769 0.897252 25.5769 0.897239 25.5769C0.897331 25.5769 0.897457 25.5769 1.03906 26.1523ZM18.7248 16.1548L19.1037 16.6056C23.0848 13.144 25.8351 9.22107 27.5896 6.16788C28.4674 4.64019 29.0978 3.32703 29.5096 2.39328C29.7156 1.9263 29.867 1.55392 29.9675 1.29669C30.0178 1.16806 30.0553 1.0682 30.0805 0.999671C30.0932 0.965407 30.1027 0.938969 30.1093 0.920683C30.1125 0.911542 30.1151 0.904434 30.1168 0.899406C30.1177 0.896894 30.1184 0.894899 30.1189 0.893428C30.1192 0.892692 30.1194 0.892089 30.1196 0.891617C30.1197 0.891381 30.1197 0.891124 30.1198 0.891005C30.1199 0.890785 30.1199 0.890595 29.5697 0.693605C29.0195 0.496616 29.0195 0.496492 29.0196 0.496401C29.0196 0.496414 29.0196 0.496356 29.0196 0.496384C29.0196 0.496438 29.0195 0.496624 29.0194 0.496938C29.0192 0.49757 29.0188 0.498723 29.0182 0.50039C29.017 0.503727 29.0151 0.50913 29.0124 0.516557C29.0071 0.531411 28.9988 0.554368 28.9875 0.585103C28.9648 0.646578 28.9301 0.739163 28.8827 0.860312C28.7881 1.10263 28.6432 1.45909 28.4446 1.90931C28.0474 2.80995 27.4358 4.08459 26.582 5.57054C24.873 8.54463 22.2008 12.3523 18.346 15.7041L18.7248 16.1548Z"
                fill="currentColor" />
            <path d="M24.8711 3.18359L29.6087 0.692486" stroke="currentColor" stroke-width="1.1772" stroke-linecap="round" />
            <path d="M30.9702 5.94987L29.6075 0.691044" stroke="currentColor" stroke-width="1.1772" stroke-linecap="round" />
            <rect x="1.62766" y="28.737" width="2.90413" height="3.53256" fill="currentColor" stroke="currentColor" stroke-width="1.1772" />
            <rect x="9.99094" y="26.1003" width="2.90413" height="6.6724" fill="currentColor" stroke="currentColor" stroke-width="1.1772" />
            <rect x="18.3542" y="20.8269" width="2.90413" height="11.3822" fill="currentColor" stroke="currentColor" stroke-width="1.1772" />
            <rect x="26.7136" y="11.5945" width="2.90413" height="20.8017" fill="currentColor" stroke="currentColor" stroke-width="1.1772" />
        </svg>
        <span class="flex-1 ms-3 text-left">Revenue</span>
        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" d="m1 1 4 4 4-4" />
        </svg>
    </button>
    <ul id="revenue-dropdown" class="hidden py-2 space-y-2">
        <li>
            <a href="/revenue?view=reports"
                class="flex items-center w-full p-2 text-gray-700 transition duration-75 rounded-lg pl-11 hover:bg-[#DFE8FC] hover:text-[#070642]">Reports</a>
        </li>
        <li>
            <a href="/revenue?view=records"
                class="flex items-center w-full p-2 text-gray-700 transition duration-75 rounded-lg pl-11 hover:bg-[#DFE8FC] hover:text-[#070642]">Records</a>
        </li>
    </ul>
</li>


            <li>
                <a href="#"
                    class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-[#DFE8FC] hover:text-[#070642] group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-[#070642]"
                        width="37" height="33" viewBox="0 0 37 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.6311 10.5176L23.1568 13.954L5.60816 31.2141C5.60816 31.2141 3.25025 34.297 0.8003 31.7999C-1.00039 29.9645 0.8003 27.8558 0.8003 27.8558L19.6311 10.5176Z" fill="currentColor" />
                        <path d="M17.3536 0.793899C17.3536 0.793899 20.3784 -1.32885 26.1279 3.09785C30.8957 6.76869 30.8957 9.89257 30.8957 9.89257H33.2596L35.9039 12.3527C35.9039 12.3527 36.1042 12.5465 36.1042 13.0166C36.1042 13.3682 35.9039 13.5242 35.9039 13.5242L30.8156 18.4836C30.8156 18.4836 30.7377 18.6009 30.3749 18.6009C29.9742 18.6009 29.8941 18.5226 29.8941 18.5226L27.0895 15.8672V13.6804H24.9259L20.038 8.99442C20.038 8.99442 19.8116 8.7577 19.7976 8.52582C19.7836 8.29394 20.038 7.97912 20.038 7.97912L22.2816 5.83136C22.2816 5.83136 21.3712 4.05249 20.3985 3.25418C18.8761 2.00458 17.3536 1.53585 17.3536 1.53585C17.3536 1.53585 17.2734 1.53598 17.2734 1.14548C17.2734 0.793899 17.3536 0.793899 17.3536 0.793899Z" fill="currentColor" />
                    </svg>
                    <span class="ms-3">Maintenance</span>
                </a>
            </li>

            <li>
                <a href="#"
                    class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-[#DFE8FC] hover:text-[#070642] group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-[#070642]"
                        width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.986754 1.44217C1.78329 0.606525 3.43015 0.793189 3.43015 0.793189H21.5676C21.5676 0.793189 22.4917 0.793189 23.3219 1.73576C24.0267 2.53606 24.0267 3.40458 24.0267 3.40458V15.6426C24.0267 15.6426 23.9941 16.7461 23.3375 17.4968C22.6484 18.2849 21.5676 18.2849 21.5676 18.2849H7.81572C7.81572 18.2849 7.37716 18.2849 6.59402 18.5939C5.91765 18.8608 5.10606 19.7374 5.10606 19.7374L0 23.9867V3.40458C0 3.40458 0 2.47738 0.986754 1.44217Z" fill="currentColor" />
                        <path d="M7.70703 19.2124H22.618C22.618 19.2124 23.1662 19.2124 24.2626 18.0072C25.2325 16.941 25.1554 16.1375 25.1554 16.1375V8.17969H29.1963C29.1963 8.17969 29.9012 8.17969 30.8409 9.13771C31.6291 9.94122 31.6084 10.4666 31.6084 10.4666V27.4947V31.2959L26.3144 26.6449C26.3144 26.6449 26.0011 26.3049 25.5313 26.0113C25.093 25.7375 24.5132 25.7641 24.5132 25.7641H10.2601C10.2601 25.7641 9.42994 25.7641 8.66246 25.0688C7.83365 24.3178 7.70703 23.6781 7.70703 23.6781V19.2124Z" fill="currentColor" />
                        <rect x="4.76172" y="6.29492" width="14.5037" height="1.11255" rx="0.556273" fill="#F4F7FC" />
                        <rect x="4.76172" y="11.7949" width="14.5037" height="1.11255" rx="0.556273" fill="#F4F7FC" />
                    </svg>
                    <span class="ms-3">Messages</span>
                </a>
            </li>
        </ul>

        <!-- Divider -->
        <div class="border-t border-gray-200 my-4"></div>

        <!-- Others Section -->
        <p class="px-3 mb-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">
            Others
        </p>

        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('settings') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-[#DFE8FC] hover:text-[#070642] group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-[#070642]"
                        width="39" height="38" viewBox="0 0 39 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M32.7236 18.768C32.7236 26.1917 26.6084 32.2099 19.0649 32.2099C11.5214 32.2099 5.40625 26.1917 5.40625 18.768C5.40625 11.3443 11.5214 5.32617 19.0649 5.32617C26.6084 5.32617 32.7236 11.3443 32.7236 18.768ZM12.8394 18.768C12.8394 22.1517 15.6267 24.8947 19.0649 24.8947C22.5031 24.8947 25.2904 22.1517 25.2904 18.768C25.2904 15.3844 22.5031 12.6413 19.0649 12.6413C15.6267 12.6413 12.8394 15.3844 12.8394 18.768Z" fill="currentColor" />
                        <path d="M13.5 2.97331C13.5 1.3312 14.8312 0 16.4733 0H21.6353C23.2774 0 24.6086 1.3312 24.6086 2.97331V9.58067H13.5V2.97331Z" fill="currentColor" />
                        <path d="M13.5 34.5853C13.5 36.2274 14.8312 37.5586 16.4733 37.5586H21.6353C23.2774 37.5586 24.6086 36.2274 24.6086 34.5853V27.9779H13.5V34.5853Z" fill="currentColor" />
                        <path d="M2.58864 15.6898C1.16652 14.8687 0.67927 13.0503 1.50033 11.6282L4.08133 7.15774C4.90238 5.73563 6.72083 5.24838 8.14294 6.06943L13.8651 9.37311L8.31078 18.9935L2.58864 15.6898Z" fill="currentColor" />
                        <path d="M35.6145 15.6898C37.0366 14.8687 37.5239 13.0503 36.7028 11.6282L34.1218 7.15774C33.3007 5.73563 31.4823 5.24838 30.0602 6.06943L24.338 9.37311L29.8923 18.9935L35.6145 15.6898Z" fill="currentColor" />
                        <path d="M8.14528 31.5075C6.72316 32.3285 4.90471 31.8413 4.08366 30.4192L1.50266 25.9488C0.681602 24.5266 1.16885 22.7082 2.59096 21.8871L8.31311 18.5835L13.8674 28.2038L8.14528 31.5075Z" fill="currentColor" />
                        <path d="M30.1008 31.5075C31.5229 32.3285 33.3414 31.8413 34.1624 30.4192L36.7434 25.9488C37.5645 24.5266 37.0772 22.7082 35.6551 21.8871L29.933 18.5835L24.3787 28.2038L30.1008 31.5075Z" fill="currentColor" />
                    </svg>
                    <span class="ms-3">Settings</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-[#DFE8FC] hover:text-[#070642] group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-[#070642]"
                        viewBox="0 0 24 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.742188 3.66903C0.742188 3.66903 0.742514 2.96625 1.74517 1.74993C2.64043 0.663891 3.8775 0.667972 3.8775 0.667972H13.2518C13.2518 0.667972 14.6146 0.657594 15.5263 1.74993C16.3634 2.75295 16.3634 3.78749 16.3634 3.78749V6.14095C16.3634 6.14095 16.3634 6.72536 15.5263 6.72536C14.5154 6.72536 14.6023 6.14095 14.6023 6.14095V3.73221C14.6023 3.73221 14.6023 3.26625 13.9152 2.70553C13.4991 2.36594 12.8096 2.36594 12.8096 2.36594H4.1934C4.1934 2.36594 3.59636 2.3528 3.12723 2.81614C2.48754 3.44794 2.48754 4.00072 2.48754 4.00072V19.4877C2.48754 19.4877 2.48754 20.1986 3.00877 20.5934C3.6437 21.0743 4.1934 20.9962 4.1934 20.9962H12.9912C12.9912 20.9962 13.6292 20.9877 14.1278 20.475C14.6886 19.8985 14.6497 19.4877 14.6497 19.4877V17.2843C14.6497 17.2843 14.6479 16.6368 15.502 16.6368C16.3634 16.6368 16.3634 17.2843 16.3634 17.2843V19.4877C16.3634 19.4877 16.3634 20.6961 15.3447 21.7464C14.4407 22.6783 13.2281 22.6783 13.2281 22.6783H4.09073C4.09073 22.6783 2.74233 22.6336 1.74517 21.7543C0.742188 20.8699 0.742188 19.4403 0.742188 19.4403V3.66903Z" fill="currentColor" />
                        <path d="M9.94156 10.8484H20.4689L19 9.46631C19 9.46631 18.4629 8.8006 19.1027 8.27379C19.6871 7.79252 20.2241 8.2264 20.2241 8.2264L22.3959 10.3982C22.3959 10.3982 23.0909 11.0458 23.0909 11.7092C23.0909 12.5068 22.4275 13.0044 22.4275 13.0044L20.2241 15.2236C20.2241 15.2236 19.7266 15.7694 19.0316 15.1051C18.5656 14.6597 19.0316 14.0232 19.0316 14.0232L20.4136 12.6411H9.94156C9.94156 12.6411 9.21311 12.5621 9.23079 11.7092C9.24762 10.9984 9.94156 10.8484 9.94156 10.8484Z" fill="currentColor" />
                    </svg>
                    <span class="ms-3">Log Out</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
