import axiosInstance from "@/services/axios";

export async function getCurrencies() {
   const currencies = await axiosInstance.get("/api/admin/currencies");
   console.log("🚀 ~ file: currencies.js:6 ~ getCurrencies ~ pairs:", currencies.data)
   return currencies.data
}

export const QUERY_KEY_CURRENCY = 'QK_currency'