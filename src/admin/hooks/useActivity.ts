import axios from "axios";
import { useQuery } from "react-query";
import { ActivityLog } from "../types/activityLog";

const fetchActivity = async (): Promise<ActivityLog[]> => {
  const { data } = await axios.get("/api/activity");
  return data;
};

export function useActivity() {
  return useQuery("activity", () => fetchActivity());
}
