export interface Donation {
  id: string;
  foodItems: string;
  weight: number;
  location: string;
  instructions: string;
  date: number;
  from: string;
  until: string;
  description: string;
  active: boolean;
}
