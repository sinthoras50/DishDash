import {
  ExitToApp as ExitToAppIcon,
  Person as PersonIcon,
} from "@mui/icons-material";
import { Avatar, Box, Fab, Grid, Tab, Tabs, Typography } from "@mui/material";
import React from "react";
import { useTranslation } from "react-i18next";
import { NavLink, Outlet } from "react-router-dom";
import { useAuth } from "../../auth/contexts/AuthProvider";
import QueryWrapper from "../../core/components/QueryWrapper";
import { useSnackbar } from "../../core/contexts/SnackbarProvider";
import AdminAppBar from "../components/AdminAppBar";
import AdminToolbar from "../components/AdminToolbar";

const profileMenuItems = [
  {
    key: "profile.menu.activity",
    path: "",
  },
  {
    key: "profile.menu.info",
    path: "./information",
  },
  {
    key: "profile.menu.password",
    path: "./password",
  },
];

const Profile = () => {
  const { isLoggingOut, logout, userInfo } = useAuth();
  const snackbar = useSnackbar();
  const { t } = useTranslation();

  const handleLogout = async () => {
    try {
      await logout();
    } catch (err: any) {
      snackbar.error(t("common.errors.unexpected.subTitle"));
    }
  };

  return (
    <React.Fragment>
      <AdminAppBar>
        <AdminToolbar>
          <Fab
            aria-label="logout"
            color="secondary"
            disabled={isLoggingOut}
            onClick={handleLogout}
          >
            <ExitToAppIcon />
          </Fab>
        </AdminToolbar>
      </AdminAppBar>
      <Grid container spacing={12}>
        <Grid item xs={12} md={4} marginTop={3}>
          <Box
            sx={{
              display: "flex",
              flexDirection: "column",
              alignItems: "center",
              textAlign: "center",
              mt: 12,
            }}
          >
            <Avatar
              sx={{
                bgcolor: "background.paper",
                mb: 3,
                height: 160,
                width: 160,
              }}
            >
              <PersonIcon sx={{ fontSize: 120 }} />
            </Avatar>
            <Typography
              component="div"
              variant="h4"
            >{`${userInfo?.firstName} ${userInfo?.lastName}`}</Typography>
            <Typography variant="body2">{userInfo?.email}</Typography>
          </Box>
        </Grid>
        <Grid item xs={12} md={8} marginTop={3}>
          <Box sx={{ mb: 4 }}>
            <Tabs aria-label="profile nav tabs" value={false}>
              {profileMenuItems.map((item) => (
                <Tab
                  key={item.key}
                  activeClassName="Mui-selected"
                  end={true}
                  component={NavLink}
                  label={t(item.key)}
                  to={item.path}
                />
              ))}
            </Tabs>
          </Box>
          <QueryWrapper>
            <Outlet />
          </QueryWrapper>
        </Grid>
      </Grid>
    </React.Fragment>
  );
};

export default Profile;
