import { DonationItem } from "./DonationItem";

export interface Donation {
  id: string;
  title: string;
  location: string;
  from: Date;
  until: Date;
  additionalInfo?: string;
  active?: boolean;
  items: DonationItem[];
  createdAt?: Date;
}
