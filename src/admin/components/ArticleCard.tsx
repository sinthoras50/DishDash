import {
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
}

const ArticleCard = ({ title, text, imageUrl, imageAlt }: ArticleCardProps) => {
  return (
    <Card sx={{ display: "flex", flexDirection: "column", height: "200px" }}>
      <Grid container spacing={2}>
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
          <CardContent style={{ display: "flex", flexDirection: "column" }}>
            <Typography variant="h5" component="div">
              {title}
            </Typography>
            <Typography variant="body2" color="text.secondary">
              {text}
            </Typography>
            <CardActions style={{ marginTop: "auto" }}>
              <Button size="small" color="primary" sx={{ padding: 0 }}>
                Learn More
              </Button>
            </CardActions>
          </CardContent>
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
      <Grid container spacing={2}>
        {currentArticles.map((article, index) => (
          <Grid item xs={12} key={index}>
            <ArticleCard
              title={article.title}
              text={article.text}
              imageUrl={article.imageUrl}
              imageAlt={article.imageAlt}
            />
          </Grid>
        ))}
      </Grid>
      <div
        style={{ display: "flex", justifyContent: "center", marginTop: "20px" }}
      >
        {Array.from(
          { length: Math.ceil(articles.length / itemsPerPage) },
          (_, index) => (
            <Button
              key={index}
              onClick={() => paginate(index + 1)}
              variant="outlined"
              color="primary"
            >
              {index + 1}
            </Button>
          )
        )}
      </div>
    </>
  );
};

export default ArticleList;
