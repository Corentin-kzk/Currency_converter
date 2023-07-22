import axiosInstance from "@/services/axios";


export async function getPairs() {
   return await axiosInstance.get("/api/pairs");
}

export const QUERY_KEY_PAIRS = "QK_Pairs"