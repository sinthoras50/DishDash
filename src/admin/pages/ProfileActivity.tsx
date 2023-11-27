import {
  Timeline,
  TimelineConnector,
  TimelineContent,
  TimelineDot,
  TimelineItem,
  TimelineSeparator,
} from "@mui/lab";
import { Box, Card, CardContent, Typography } from "@mui/material";
import { formatDistanceToNow } from "date-fns";
import { Trans, useTranslation } from "react-i18next";
import Empty from "../../core/components/Empty";
import { useDateLocale } from "../../core/hooks/useDateLocale";
import { useActivityLogs } from "../hooks/useActivityLogs";
import { logKeys } from "../config/activity";

const ProfileActivity = () => {
  const locale = useDateLocale();
  const { t } = useTranslation();

  const { data } = useActivityLogs();

  if (!data || data.length === 0) {
    return <Empty title={t("profile.activity.empty")} />;
  }

  return (
    <Box sx={{ "& .MuiTimelineItem-root:before": { content: "none" } }}>
      <Timeline>
        {data.map((log) => (
          <TimelineItem key={log.id}>
            <TimelineSeparator>
              <TimelineDot color="grey" />
              <TimelineConnector color="grey" />
            </TimelineSeparator>
            <TimelineContent>
              <Card>
                <CardContent>
                  <Trans
                    components={{ bold: <strong /> }}
                    defaults="<bold>You</bold> modify resource <bold>{{ resouce }}</bold>"
                    i18nKey={logKeys[log.code]}
                    values={log.params}
                  />
                  <Typography component="div" marginTop={1} variant="caption">
                    {formatDistanceToNow(new Date(log.createdAt), {
                      addSuffix: true,
                      locale,
                    })}
                  </Typography>
                </CardContent>
              </Card>
            </TimelineContent>
          </TimelineItem>
        ))}
      </Timeline>
    </Box>
  );
};

export default ProfileActivity;
