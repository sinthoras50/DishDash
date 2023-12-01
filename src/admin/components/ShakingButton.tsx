import { keyframes } from "@emotion/react";
import Button from "@mui/material/Button";
import { useEffect, useState } from "react";

const rotateAnimation = keyframes`
  0% {
    transform: rotate(0deg);
  }
  25% {
    transform: rotate(-5deg);
  }
  50% {
    transform: rotate(5deg);
  }
  75% {
    transform: rotate(-5deg);
  }
  100% {
    transform: rotate(0deg);
  }
`;

interface RotatingButtonProps {
  buttonText: string;
}

const RotatingButton = ({ buttonText }: RotatingButtonProps) => {
  const [rotate, setRotate] = useState(false);

  useEffect(() => {
    const timeoutId = setTimeout(() => {
      setRotate(true);

      setTimeout(() => {
        setRotate(false);
      }, 500);
    }, 3000);
    return () => clearTimeout(timeoutId);
  }, [rotate]);

  return (
    <Button
      variant="contained"
      sx={{
        mb: 7,
        animation: rotate ? `${rotateAnimation} 0.5s ease-in-out` : "none",
      }}
    >
      {buttonText}
    </Button>
  );
};

export default RotatingButton;
