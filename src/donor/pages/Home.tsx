import { Typography } from "@mui/material";
import { useTranslation } from "react-i18next";
import AdminAppBar from "../../admin/components/AdminAppBar";
import AdminToolbar from "../../admin/components/AdminToolbar";
import RecentNotifications from "../../admin/components/RecentNotifications";
import { useAuth } from "../../auth/contexts/AuthProvider";
import Carousel from "../../core/components/CardCarousel";
import RotatingNavButton from "../../core/components/RotatingNavButton";
import articles from "../../mocks/articles.json";
import donations from "../../mocks/donations.json";
import events from "../../mocks/events.json";
import ArticleList from "../components/ArticleList";

const Home = () => {
  const { userInfo } = useAuth();
  const { t } = useTranslation();

  const donationData = donations
    .filter((donation) => donation.active)
    .map((donation) => ({
      title: donation.title,
      description: donation.location,
      imageAlt: donation.imageAlt,
      imageUrl: donation.imageUrl,
      actionText: t("donor.home.activeDonations.action"),
    }));

  const eventData = events.map((event) => ({
    title: event.title,
    description: event.location,
    imageAlt: event.imageAlt,
    imageUrl: event.imageUrl,
    actionText: t("donor.home.upcomingEvents.action"),
  }));

  const articleData = articles.map((article) => ({
    ...article,
    actionText: t("donor.home.community.action"),
  }));

  return (
    <>
      <AdminAppBar>
        <AdminToolbar>
          <RecentNotifications />
        </AdminToolbar>
      </AdminAppBar>
      <Typography component="div" variant="h1" sx={{ mb: 2 }}>
        {t("admin.home.welcome.title", { name: userInfo?.firstName })}
      </Typography>
      <Typography component="div" sx={{ fontWeight: 300, mb: 3 }} variant="h3">
        {t("admin.home.welcome.subTitle")}
      </Typography>
      <RotatingNavButton
        buttonText={t("admin.home.welcome.cta")}
        to={`/${process.env.PUBLIC_URL}/admin/donations/new`}
      />
      <Typography component="div" variant="h2" sx={{ mt: 3 }}>
        {t("admin.home.carousels.activeDonations.title")}
      </Typography>
      <Carousel cards={donationData} cardsPerPage={5} />
      <Typography component="div" variant="h2" sx={{ mt: 10 }}>
        {t("admin.home.carousels.upcomingEvents.title")}
      </Typography>
      <Carousel cards={eventData} cardsPerPage={3} />
      <Typography component="div" variant="h2" sx={{ mt: 10, mb: 3 }}>
        {t("admin.home.community.title")}
      </Typography>
      <ArticleList articles={articleData} itemsPerPage={3} />
    </>
  );
};

export default Home;
