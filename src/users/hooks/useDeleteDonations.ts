import axios from "axios";
import { useMutation, useQueryClient } from "react-query";
import { removeMany } from "../../core/utils/crudUtils";
import { Donation } from "../types/donation";

const deleteDonations = async (donationIds: string[]): Promise<string[]> => {
  const { data } = await axios.delete("/api/donations", { data: donationIds });
  return data;
};

export function useDeleteDonations() {
  const queryClient = useQueryClient();

  const { isLoading, mutateAsync } = useMutation(deleteDonations, {
    onSuccess: (donationIds: string[]) => {
      queryClient.setQueryData<Donation[]>(["donations"], (oldDonations) =>
        removeMany(oldDonations, donationIds)
      );
    },
  });

  return { isDeleting: isLoading, deleteDonations: mutateAsync };
}
