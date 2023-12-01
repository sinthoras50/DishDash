import axios from "axios";
import { useMutation, useQueryClient } from "react-query";
import { UserInfo } from "../../auth/types/userInfo";

const updateUserInfo = async (userInfo: UserInfo): Promise<UserInfo> => {
  const { data } = await axios.put("/api/user", userInfo);
  return data;
};

export function useUpdateUserInfo() {
  const queryClient = useQueryClient();

  const { isLoading, mutateAsync } = useMutation(updateUserInfo, {
    onSuccess: (userInfo: UserInfo) => {
      queryClient.setQueryData(["user", userInfo.token], userInfo);
    },
  });

  return { isUpdating: isLoading, updateUserInfo: mutateAsync };
}
