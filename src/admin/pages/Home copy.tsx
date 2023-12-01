import { Typography } from "@mui/material";
import React from "react";
import { useTranslation } from "react-i18next";
import { useAuth } from "../../auth/contexts/AuthProvider";
import articleData from "../../mocks/articles.json";
import donations from "../../mocks/donations.json";
import eventData from "../../mocks/events.json";
import AdminAppBar from "../components/AdminAppBar";
import AdminToolbar from "../components/AdminToolbar";
import ArticleList from "../components/ArticleCard";
import RecentNotifications from "../components/RecentNotifications";
import ShakingButton from "../components/ShakingButton";
import Carousel from "./Carousel";

const Home = () => {
  const { userInfo } = useAuth();
  const { t } = useTranslation();

  const cardData = donations.map((donation) => ({
    title: donation.foodItems,
    description: donation.description,
    imageAlt: donation.imageAlt,
    imageUrl: donation.imageUrl,
    buttonText: "admin.home.view",
  }));

  return (
    <React.Fragment>
      <AdminAppBar>
        <AdminToolbar>
          <RecentNotifications />
        </AdminToolbar>
      </AdminAppBar>
      <Typography component="div" gutterBottom variant="h1" sx={{ mb: 1 }}>
        {t("admin.home.welcome.title", { name: userInfo?.firstName })}
      </Typography>
      <Typography component="div" sx={{ fontWeight: 300, mb: 2 }} variant="h3">
        {t("admin.home.welcome.subTitle")}
      </Typography>
      <ShakingButton buttonText={t("admin.home.welcome.cta")} />
      <Typography component="div" gutterBottom variant="h2">
        {t("admin.home.carousels.activeDonations.title")}
      </Typography>
      <Carousel cards={cardData} cardsPerPage={5} />
      <Typography component="div" gutterBottom variant="h2" mt="3rem">
        {t("admin.home.carousels.upcomingEvents.title")}
      </Typography>
      <Carousel cards={eventData} cardsPerPage={3} />
      <Typography component="div" gutterBottom variant="h2" mt="3rem">
        {t("admin.home.community.title")}
      </Typography>
      <ArticleList articles={articleData} itemsPerPage={3} />;
    </React.Fragment>
  );
};

export default Home;
