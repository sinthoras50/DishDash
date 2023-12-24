import { useTranslation } from "react-i18next";
import { useNavigate, useParams } from "react-router-dom";
import { Donation } from "../types/Donation";
import { useState, useEffect } from "react";
import {
  Coffee as CoffeeIcon,
  Egg as EggIcon,
  LocalPizza as LocalPizzaIcon,
  Pets as PetsIcon,
  ShoppingBag as ShoppingBagIcon,
} from "@mui/icons-material";
import {
  Box,
  FormControl,
  FormHelperText,
  Grid,
  InputLabel,
  List,
  ListItem,
  ListItemText,
  MenuItem,
  Select,
  TextField,
  Typography,
  useTheme,
  Modal,
  Fade,
  Backdrop
} from "@mui/material";
import { useSnackbar } from "../../core/contexts/SnackbarProvider";
import { useDonations } from "../hooks/useDonations";
import { DonationItem } from "../types/DonationItem";

interface DonationModalProps {
  open: boolean,
  handleClose: () => void
};

const units = [
  {
    label: "donor.editDonation.units.grams.label",
    value: "g",
  },
  {
    label: "donor.editDonation.units.kilograms.label",
    value: "kg",
  },
  {
    label: "donor.editDonation.units.liters.label",
    value: "l",
  },
  {
    label: "donor.editDonation.units.deciliters.label",
    value: "dl",
  },
  {
    label: "donor.editDonation.units.milliliters.label",
    value: "ml",
  },
  {
    label: "donor.editDonation.units.pieces.label",
    value: "pc",
  },
];

const foodTypes = [
  {
    label: "donor.editDonation.foodTypes.grocery.label",
    value: "grocery",
  },
  {
    label: "donor.editDonation.foodTypes.preparedFood.label",
    value: "preparedFood",
  },
  {
    label: "donor.editDonation.foodTypes.fruitsVegetables.label",
    value: "fruitsVegetables",
  },
  {
    label: "donor.editDonation.foodTypes.beverages.label",
    value: "beverages",
  },
  {
    label: "donor.editDonation.foodTypes.petFood.label",
    value: "petFood",
  },
];

const style = {
  position: "absolute" as "absolute",
  top: "50%",
  left: "50%",
  transform: "translate(-50%, -50%)",
  width: "auto",
  bgcolor: "background.paper",
  border: "2px solid #000",
  boxShadow: 24,
  borderRadius: "25px",
  p: 4,
};

const DonationModal = (props: DonationModalProps) => {

  const { open, handleClose } = props;
  const { id } = useParams();
  const { t } = useTranslation();
  const [items, setItems] = useState<DonationItem[]>([]);
  const [itemsStatus, setItemsStatus] = useState("");
  const theme = useTheme();
  const snackbar = useSnackbar();
  const navigate = useNavigate();
  const { data } = useDonations();
  const donation = data?.find((donation) => donation.id === id);

  const editMode = window.location.href.includes("/edit/");
  const repeatMode = window.location.href.includes("/repeat/");



  useEffect(() => {
    if (donation) {
      setItems(donation.items);
    } else if (editMode || repeatMode) {
      navigate(`/${process.env.PUBLIC_URL}/404`);
    }
  }, [donation, navigate, editMode, repeatMode]);

  return (
    <Modal
      aria-labelledby="transition-modal-title"
      aria-describedby="transition-modal-description"
      open={open}
      onClose={handleClose}
      closeAfterTransition
      slots={{ backdrop: Backdrop }}
      slotProps={{
        backdrop: {
          timeout: 500,
        },
      }}
    >
      <Fade in={open}>
        <Box sx={style}>
        <Grid container spacing={3}>
        <Grid item xs={12} md={6}>
          <Typography component="h2" variant="h3" sx={{ mb: 1 }}>
            {t("donor.editDonation.infoForm.title")}
          </Typography>

          <Box component="form" noValidate>
            <TextField
              margin="normal"
              required
              fullWidth
              id="title"
              label={t("donor.editDonation.infoForm.donationTitle.label")}
              placeholder={t(
                "donor.editDonation.infoForm.donationTitle.placeholder"
              )}
              name="title"
              autoFocus
              disabled
              value={"asdf"}
              helperText={"asdf"}
            />
            <TextField
              margin="normal"
              required
              fullWidth
              id="location"
              label={t("donor.editDonation.infoForm.location.label")}
              placeholder={t(
                "donor.editDonation.infoForm.location.placeholder"
              )}
              name="location"
              disabled
              value={"asdsa"}
              helperText={"dadsa"}
            />

            <Typography
              component="h2"
              variant="body2"
              sx={{ mb: 1, mt: 1 }}
              color="text.secondary"
            >
              {t("donor.editDonation.infoForm.from.label")}
            </Typography>

            <Typography
              component="h2"
              variant="body2"
              sx={{ mb: 1, mt: 2 }}
              color="text.secondary"
            >
              {t("donor.editDonation.infoForm.until.label")}
            </Typography>

            <TextField
              margin="normal"
              fullWidth
              id="additionalInfo"
              label={t("donor.editDonation.infoForm.additionalInfo.label")}
              placeholder={t(
                "donor.editDonation.infoForm.additionalInfo.placeholder"
              )}
              multiline={true}
              rows={3}
              name="additionalInfo"
              disabled
              value="asdas"
              helperText="dsadas"
            />
          </Box>
        </Grid>

        <Grid item xs={12} md={6}>
          <Typography component="h2" variant="h3" sx={{ mb: 1 }}>
            {t("donor.editDonation.itemForm.title")}
          </Typography>

          <FormHelperText
            error={Boolean(itemsStatus)}
            component="h1"
            sx={{ mb: 1 }}
          >
            <Typography variant="body1">{itemsStatus}</Typography>
          </FormHelperText>

          <Box
            component="form"
            noValidate
            sx={{ mb: 1 }}
          >
            <Grid container spacing={2} alignItems="center">
              <Grid item xs={4}>
                <TextField
                  margin="normal"
                  required
                  fullWidth
                  id="name"
                  label={t("donor.editDonation.itemForm.name.label")}
                  placeholder={t(
                    "donor.editDonation.itemForm.name.placeholder"
                  )}
                  name="name"
                  disabled
                  value="adsa"
                  helperText="helpers"
                />
              </Grid>
              <Grid item xs={2}>
                <FormControl
                  component="fieldset"
                  margin="normal"
                  sx={{ maxWidth: "100%", width: "100%" }}
                >
                  <InputLabel id="typeLabel">
                    {t("donor.editDonation.itemForm.type.label")}
                  </InputLabel>
                  <Select
                    labelId="typeLabel"
                    id="type"
                    name="type"
                    required
                    value="valuebsda"
                    label={t("donor.editDonation.itemForm.type.label")}
                  >
                    {foodTypes.map((type, index) => (
                      <MenuItem key={index} value={type.value}>
                        {t(type.label)}
                      </MenuItem>
                    ))}
                  </Select>
                </FormControl>
              </Grid>
              <Grid item xs={2}>
                <TextField
                  margin="normal"
                  required
                  fullWidth
                  type="number"
                  id="quantity"
                  label={t("donor.editDonation.itemForm.quantity.label")}
                  name="quantity"
                  disabled
                  value="123"
                  helperText="somehelpyouare"
                />
              </Grid>
              <Grid item xs={2}>
                <FormControl
                  component="fieldset"
                  margin="normal"
                  sx={{ maxWidth: "100%", width: "100%" }}
                >
                  <InputLabel id="unitLabel">
                    {t("donor.editDonation.itemForm.unit.label")}
                  </InputLabel>
                  <Select
                    labelId="unitLabel"
                    id="unit"
                    name="unit"
                    required
                    value="ok"
                    label={t("donor.editDonation.itemForm.unit.label")}
                  >
                    {units.map((unit, index) => (
                      <MenuItem key={index} value={unit.value}>
                        {t(unit.label)}
                      </MenuItem>
                    ))}
                  </Select>
                </FormControl>
              </Grid>
            </Grid>
          </Box>

          <List>
            {items.map((item, index) => (
              <ListItem
                sx={{
                  borderRadius: 16,
                  border: `1px solid ${theme.palette.text.secondary}`,
                  py: 0,
                  mb: 2,
                }}
                key={index}
              >
                {item.type === "grocery" && <ShoppingBagIcon />}
                {item.type === "preparedFood" && <LocalPizzaIcon />}
                {item.type === "fruitsVegetables" && <EggIcon />}
                {item.type === "beverages" && <CoffeeIcon />}
                {item.type === "petFood" && <PetsIcon />}

                <ListItemText
                  primary={item.name}
                  secondary={item.quantity + item.unit}
                  sx={{
                    ml: 2,
                    whiteSpace: "nowrap",
                    overflow: "hidden",
                    textOverflow: "ellipsis",
                  }}
                />
              </ListItem>
            ))}
          </List>
        </Grid>
      </Grid>
        </Box>
      </Fade>
    </Modal>  
  )
}

export default DonationModal;