export interface ProfileInfo {
  id: string;
  firstName: string;
  lastName: string;
  avatar?: string;
  email: string;
  gender?: "F" | "M" | "NC";
  job: string;
}
