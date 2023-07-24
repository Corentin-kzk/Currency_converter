import axiosInstance from "@/services/axios";
import { store } from "../auth";

export async function getPairs() {
   const pairs = await axiosInstance.get("/api/pairs");
   return pairs.data.pairs
}

export async function updatePair(form){
   const res = await axiosInstance.put(`/api/admin/pairs/${form.id}`, form);
   return res
}

export async function createPair(form){
   const res = await axiosInstance.post(`/api/admin/pairs`, form);
   return res
}

export async function getPair(id) {
   const pairs = await axiosInstance.get(`/api/admin/pairs/${id}`);
   return pairs.data
}

export async function deletePair(id) {
   const pair = await axiosInstance.delete(`api/admin/pairs/${id}`);
   return pair
}

export const QUERY_KEY_PAIRS = "QK_Pairs"