import axiosInstance from "@/services/axios";

export async function getCurrencies() {
   const pairs = await axiosInstance.get("/api/admin/currencies");
   // console.log("🚀 ~ file: currencies.js:6 ~ getCurrencies ~ pairs:", pairs.data)
   return pairs.data
}

export const QUERY_KEY_CURRENCY = 'QK_currency'