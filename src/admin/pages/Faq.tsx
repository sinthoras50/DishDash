import { ExpandMore as ExpandMoreIcon } from "@mui/icons-material";
import {
  Accordion,
  AccordionDetails,
  AccordionSummary,
  Container,
  Typography,
} from "@mui/material";
import React from "react";
import { useTranslation } from "react-i18next";
import AdminAppBar from "../components/AdminAppBar";
import AdminToolbar from "../components/AdminToolbar";

const questions = [
  {
    title: "faq.questions.title1",
    answer: "faq.questions.answer1",
  },
  {
    title: "faq.questions.title2",
    answer: "faq.questions.answer2",
  },
  {
    title: "faq.questions.title3",
    answer: "faq.questions.answer3",
  },
  {
    title: "faq.questions.title4",
    answer: "faq.questions.answer4",
  },
  {
    title: "faq.questions.title5",
    answer: "faq.questions.answer5",
  },
  {
    title: "faq.questions.title6",
    answer: "faq.questions.answer6",
  },
];

const Faq = () => {
  const { t } = useTranslation();

  return (
    <React.Fragment>
      <AdminAppBar>
        <AdminToolbar />
      </AdminAppBar>
      <Container maxWidth="sm">
        <Typography align="center" marginBottom={3} variant="h2">
          {t("faq.title")}
        </Typography>
        {questions.map((question, index) => (
          <Accordion key={index} disableGutters>
            <AccordionSummary expandIcon={<ExpandMoreIcon />}>
              <Typography component="p" variant="h6">
                {t(question.title)}
              </Typography>
            </AccordionSummary>
            <AccordionDetails>
              <Typography color="text.secondary">
                {t(question.answer)}
              </Typography>
            </AccordionDetails>
          </Accordion>
        ))}
      </Container>
    </React.Fragment>
  );
};

export default Faq;
