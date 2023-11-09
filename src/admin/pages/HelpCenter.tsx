import {
  Help as HelpIcon,
  Mail as MailIcon,
  School as SchoolIcon,
  Support as SupportIcon,
} from "@mui/icons-material";
import {
  Avatar,
  Badge,
  Card,
  CardActionArea,
  CardContent,
  CardHeader,
  Container,
  Grid,
  Typography,
} from "@mui/material";
import React from "react";
import { useTranslation } from "react-i18next";
import { Link as RouterLink } from "react-router-dom";
import { ReactComponent as HelpSvg } from "../../core/assets/help.svg";
import SvgContainer from "../../core/components/SvgContainer";
import AdminAppBar from "../components/AdminAppBar";
import AdminToolbar from "../components/AdminToolbar";

const HelpCenter = () => {
  const { t } = useTranslation();

  return (
    <React.Fragment>
      <AdminAppBar>
        <AdminToolbar title={t("help.title")} />
      </AdminAppBar>
      <Container maxWidth="xs" sx={{ mt: 3 }}>
        <SvgContainer>
          <HelpSvg />
        </SvgContainer>
      </Container>
      <Grid container spacing={2} sx={{ mt: 3 }}>
        <Grid item xs={6} lg={3}>
          <Card>
            <CardActionArea disabled={true}>
              <CardHeader
                avatar={
                  <Avatar aria-label="Guides icon">
                    <SchoolIcon />
                  </Avatar>
                }
              />
              <CardContent>
                <Badge
                  badgeContent="Coming soon"
                  color="primary"
                  sx={{
                    "& .MuiBadge-badge": {
                      top: -8,
                      right: 10,
                      whiteSpace: "nowrap",
                    },
                  }}
                >
                  <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
                    {t("help.menu.guide")}
                  </Typography>
                </Badge>
              </CardContent>
            </CardActionArea>
          </Card>
        </Grid>
        <Grid item xs={6} lg={3}>
          <Card>
            <CardActionArea
              component={RouterLink}
              to={`/${process.env.PUBLIC_URL}/admin/faq`}
            >
              <CardHeader
                avatar={
                  <Avatar aria-label="FAQ icon">
                    <HelpIcon />
                  </Avatar>
                }
              />
              <CardContent>
                <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
                  {t("help.menu.faq")}
                </Typography>
              </CardContent>
            </CardActionArea>
          </Card>
        </Grid>
        <Grid item xs={6} lg={3}>
          <Card>
            <CardActionArea
              component="a"
              href={process.env.REACT_APP_SUPPORT_LINK}
              rel="noopener noreferrer"
              target="_blank"
            >
              <CardHeader
                avatar={
                  <Avatar aria-label="Support icon">
                    <SupportIcon />
                  </Avatar>
                }
              />
              <CardContent>
                <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
                  {t("help.menu.support")}
                </Typography>
              </CardContent>
            </CardActionArea>
          </Card>
        </Grid>
        <Grid item xs={6} lg={3}>
          <Card>
            <CardActionArea
              component="a"
              href={`mailto:${process.env.REACT_APP_CONTACT_MAIL}`}
            >
              <CardHeader
                avatar={
                  <Avatar aria-label="Mail icon">
                    <MailIcon />
                  </Avatar>
                }
              />
              <CardContent>
                <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
                  {t("help.menu.contact")}
                </Typography>
              </CardContent>
            </CardActionArea>
          </Card>
        </Grid>
      </Grid>
    </React.Fragment>
  );
};

export default HelpCenter;
