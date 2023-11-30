import axios from "axios";
import { useMutation, useQueryClient } from "react-query";
import { updateOne } from "../../core/utils/crudUtils";
import { Donation } from "../types/donation";

const updateDonation = async (donation: Donation): Promise<Donation> => {
  const { data } = await axios.put("/api/donations", donation);
  return data;
};

export function useUpdateDonation() {
  const queryClient = useQueryClient();

  const { isLoading, mutateAsync } = useMutation(updateDonation, {
    onSuccess: (donation: Donation) => {
      queryClient.setQueryData<Donation[]>(["donations"], (oldDonations) =>
        updateOne(oldDonations, donation)
      );
    },
  });

  return { isUpdating: isLoading, updateDonation: mutateAsync };
}
