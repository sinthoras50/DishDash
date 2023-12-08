import {
  Box,
  Button,
  Card,
  CardActions,
  CardContent,
  Grid,
  Typography,
} from "@mui/material";
import { useState } from "react";

interface ArticleCardProps {
  title: string;
  text: string;
  imageUrl: string;
  imageAlt: string;
  actionText: string;
}

const ArticleCard = ({
  title,
  text,
  imageUrl,
  imageAlt,
  actionText,
}: ArticleCardProps) => {
  return (
    <Card
      sx={{
        display: "flex",
        flexDirection: "column",
        height: "200px",
        overflow: "hidden",
      }}
    >
      <Grid container spacing={3}>
        <Grid item md={4}>
          <img
            style={{
              width: "100%",
              height: "100%",
              objectFit: "cover",
              marginTop: "-30px",
            }}
            alt={imageAlt}
            src={imageUrl}
          />
        </Grid>
        <Grid item xs>
          <CardContent
            sx={{
              flexGrow: 1,
              overflow: "hidden",
              textOverflow: "ellipsis",
            }}
          >
            <Typography
              variant="h5"
              component="div"
              sx={{
                mb: 1,
              }}
            >
              {title}
            </Typography>
            <Typography variant="body2" color="text.secondary">
              {text}
            </Typography>
          </CardContent>
          <CardActions sx={{ mt: "auto" }}>
            <Button size="small" variant="outlined" sx={{ py: 0, mt: "auto" }}>
              {actionText}
            </Button>
          </CardActions>
        </Grid>
      </Grid>
    </Card>
  );
};

interface ArticleListProps {
  articles: ArticleCardProps[];
  itemsPerPage: number;
}

const ArticleList = ({ articles, itemsPerPage }: ArticleListProps) => {
  const [currentPage, setCurrentPage] = useState(1);

  const indexOfLastArticle = currentPage * itemsPerPage;
  const indexOfFirstArticle = indexOfLastArticle - itemsPerPage;
  const currentArticles = articles.slice(
    indexOfFirstArticle,
    indexOfLastArticle
  );

  const paginate = (pageNumber: number) => {
    setCurrentPage(pageNumber);
  };

  return (
    <>
      <Grid container gap={3}>
        {currentArticles.map((article, index) => (
          <Grid item xs={12} key={index}>
            <ArticleCard
              title={article.title}
              text={article.text}
              imageUrl={article.imageUrl}
              imageAlt={article.imageAlt}
              actionText={article.actionText}
            />
          </Grid>
        ))}
      </Grid>
      <Box sx={{ display: "flex", justifyContent: "right", marginTop: 3 }}>
        {Array.from(
          { length: Math.ceil(articles.length / itemsPerPage) },
          (_, index) => (
            <Button
              key={index}
              size="small"
              onClick={() => paginate(index + 1)}
              variant={currentPage === index + 1 ? "contained" : "outlined"}
              color="primary"
              sx={{ py: 0, ml: 1 }}
            >
              {index + 1}
            </Button>
          )
        )}
      </Box>
    </>
  );
};

export default ArticleList;
