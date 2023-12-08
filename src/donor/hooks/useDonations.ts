import axios from "axios";
import { useQuery } from "react-query";
import { Donation } from "../types/Donation";

const fetchDonations = async (): Promise<Donation[]> => {
  const { data } = await axios.get("/api/donations");
  return data;
};

export function useDonations() {
  return useQuery("donations", () => fetchDonations());
}
