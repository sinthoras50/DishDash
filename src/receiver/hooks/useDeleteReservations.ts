import axios from "axios";
import { useMutation, useQueryClient } from "react-query";
import { removeMany } from "../../core/utils/crudUtils";
import { Reservation } from "../../donor/types/Reservation";

const deleteReservations = async (
  reservationIds: string[]
): Promise<string[]> => {
  const { data } = await axios.delete("/api/reservations", {
    data: reservationIds,
  });
  return data;
};

export function useDeleteReservations() {
  const queryClient = useQueryClient();

  const { isLoading, mutateAsync } = useMutation(deleteReservations, {
    onSuccess: (reservationIds: string[]) => {
      queryClient.setQueryData<Reservation[]>(
        ["reservations"],
        (oldReservations) => removeMany(oldReservations, reservationIds)
      );
    },
  });

  return { isDeleting: isLoading, deleteReservations: mutateAsync };
}
