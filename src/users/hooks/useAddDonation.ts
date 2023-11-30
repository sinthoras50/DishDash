import axios from "axios";
import { useMutation, useQueryClient } from "react-query";
import { addOne } from "../../core/utils/crudUtils";
import { Donation } from "../types/donation";

const addDonation = async (donation: Donation): Promise<Donation> => {
  const { data } = await axios.post("/api/donations", donation);
  return data;
};

export function useAddDonation() {
  const queryClient = useQueryClient();

  const { isLoading, mutateAsync } = useMutation(addDonation, {
    onSuccess: (donation: Donation) => {
      queryClient.setQueryData<Donation[]>(["donations"], (oldDonations) =>
        addOne(oldDonations, donation)
      );
    },
  });

  return { isAdding: isLoading, addDonation: mutateAsync };
}
