import { ArrowBack, ArrowForward } from "@mui/icons-material";
import {
  Box,
  Button,
  Card,
  CardActions,
  CardContent,
  CardMedia,
  Grid,
  Slide,
  Typography,
} from "@mui/material";
import { useState } from "react";
import { useTranslation } from "react-i18next";

interface CarouselProps {
  cards: Array<{ title: string; description: string; imageUrl: string }>;
  cardsPerPage: number;
}

const Carousel = ({ cards, cardsPerPage }: CarouselProps) => {
  const [currentCard, setCurrentCard] = useState(0);
  const { t } = useTranslation();

  const handleNext = () => {
    setCurrentCard((prevCard) => (prevCard + 1) % cards.length);
  };

  const handlePrev = () => {
    setCurrentCard((prevCard) => (prevCard - 1 + cards.length) % cards.length);
  };

  return (
    <>
      <Box
        sx={{
          display: "flex",
          flexDirection: "row",
          justifyContent: "space-between",
        }}
      >
        <Button
          onClick={handlePrev}
          startIcon={<ArrowBack />}
          disabled={currentCard === 0}
        >
          {t("common.carousel.prevPage")}
        </Button>
        <Button
          onClick={handleNext}
          endIcon={<ArrowForward />}
          disabled={currentCard >= cards.length - 3}
        >
          {t("common.carousel.nextPage")}
        </Button>
      </Box>

      <Slide direction="left" in mountOnEnter unmountOnExit>
        <Grid container spacing={2} justifyContent="left">
          {cards
            .slice(currentCard, currentCard + cardsPerPage)
            .map((card, index) => (
              <Grid item key={index} width={`${100 / cardsPerPage}%`}>
                <Card sx={{ height: "320px " }}>
                  <CardMedia
                    component="img"
                    height="180"
                    image={card.imageUrl}
                    alt={card.title}
                  />
                  <CardContent>
                    <Typography variant="h5" component="div">
                      {card.title}
                    </Typography>
                    <Typography variant="body2" color="text.secondary">
                      {card.description}
                    </Typography>
                  </CardContent>
                  <CardActions>
                    <Button
                      size="small"
                      color="primary"
                      sx={{ p: 0, mt: "auto" }}
                    >
                      Learn More
                    </Button>
                  </CardActions>
                </Card>
              </Grid>
            ))}
        </Grid>
      </Slide>
    </>
  );
};

export default Carousel;
