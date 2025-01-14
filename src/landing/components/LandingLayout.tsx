import {
  Login as LoginIcon,
  Settings as SettingsIcon,
} from "@mui/icons-material";
import {
  AppBar,
  Box,
  Button,
  IconButton,
  Paper,
  Tab,
  Tabs,
  Toolbar,
  Typography,
} from "@mui/material";
import React, { useState } from "react";
import { useTranslation } from "react-i18next";
import { NavLink, Link as RouterLink } from "react-router-dom";
import Footer from "../../core/components/Footer";
import Logo from "../../core/components/Logo";
import SettingsDrawer from "../../core/components/SettingsDrawer";

type LandingLayoutProps = {
  children: React.ReactNode;
};

const landingNavItems = [
  {
    key: "landing.nav.getStarted",
    path: "register",
  },
  {
    key: "landing.nav.howItWorks",
    path: "howItWorks",
  },
  {
    key: "landing.nav.aboutUs",
    path: "aboutUs",
  },
  {
    key: "landing.nav.contact",
    path: "contact",
  },
];

const LandingLayout = ({ children }: LandingLayoutProps) => {
  const { t } = useTranslation();
  const [settingsOpen, setSettingsOpen] = useState(false);

  const handleSettingsToggle = () => {
    setSettingsOpen(!settingsOpen);
  };

  return (
    <Paper square>
      <AppBar color="transparent" position="relative" sx={{ mb: 5 }}>
        <Toolbar>
          <Box
            sx={{
              display: "flex",
              alignItems: "center",
              justifyContent: "space-between",
              flexGrow: 1,
            }}
          >
            <Box
              component={RouterLink}
              to={`/${process.env.PUBLIC_URL}`}
              sx={{
                display: "flex",
                alignItems: "center",
                mt: -2,
                textDecoration: "none",
                color: "text.primary",
              }}
            >
              <Logo size={24} sx={{ mr: 1 }} />
              <Typography variant="h6" color="inherit" noWrap sx={{ mt: -0.5 }}>
                {process.env.REACT_APP_NAME}
              </Typography>
            </Box>

            <Tabs aria-label={t("landing.nav.tabsAria")} value={false}>
              {landingNavItems.map((item, i) => (
                <Tab
                key={item.key}
                activeClassName="Mui-selected"
                end={true}
                component={NavLink}
                label={t(item.key)}
                to={(i === 0) ? `/${process.env.PUBLIC_URL}/${item.path}` : `/${process.env.PUBLIC_URL}/#${item.path}`}
                />)
              )}
            </Tabs>

            <Box sx={{ display: "flex", alignItems: "center" }}>
              <Button
                component={RouterLink}
                to={`/${process.env.PUBLIC_URL}/login`}
                variant="contained"
                startIcon={<LoginIcon />}
                sx={{ mr: 1 }}
                size="small"
              >
                {t("landing.nav.cta")}
              </Button>

              <IconButton
                color="default"
                aria-label={t("landing.nav.settingsAria")}
                component="span"
                onClick={handleSettingsToggle}
              >
                <SettingsIcon />
              </IconButton>
            </Box>
          </Box>
        </Toolbar>
      </AppBar>

      <SettingsDrawer
        onDrawerToggle={handleSettingsToggle}
        open={settingsOpen}
      />

      <Box component="main" sx={{ px: "5%" }}>
        {children}
      </Box>

      <Footer />
    </Paper>
  );
};

export default LandingLayout;
