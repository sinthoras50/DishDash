import axios from "axios";
import { useQuery } from "react-query";
import { Donation } from "../types/Donation";

const fetchDonation = async (id: string): Promise<Donation> => {
  const { data } = await axios.get(`/api/donations/${id}`);
  return data;
};

export function useDonation(id: string) {
  return useQuery(["donation", id], () => fetchDonation(id), {
    enabled: !!id,
  });
}
