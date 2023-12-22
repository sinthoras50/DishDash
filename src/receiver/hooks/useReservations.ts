import axios from "axios";
import { useQuery } from "react-query";
import { Reservation } from "../../donor/types/Reservation";

const fetchReservations = async (): Promise<Reservation[]> => {
  const { data } = await axios.get("/api/reservations");
  return data;
};

export function useReservations() {
  return useQuery("reservations", () => fetchReservations());
}
