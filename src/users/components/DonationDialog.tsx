import { LoadingButton } from "@mui/lab";
import {
  Button,
  Dialog,
  DialogActions,
  DialogContent,
  DialogTitle,
  TextField,
} from "@mui/material";
import { useFormik } from "formik";
import { useTranslation } from "react-i18next";
import * as Yup from "yup";
import { Donation } from "../types/donation";

type DonationDialogProps = {
  onAdd: (donation: Partial<Donation>) => void;
  onClose: () => void;
  onUpdate: (donation: Donation) => void;
  open: boolean;
  processing: boolean;
  donation?: Donation;
};

const DonationDialog = ({
  onAdd,
  onClose,
  onUpdate,
  open,
  processing,
  donation,
}: DonationDialogProps) => {
  const { t } = useTranslation();

  const editMode = Boolean(donation && donation.id);
  console.log(donation);

  const handleSubmit = (values: Partial<Donation>) => {
    if (donation && donation.id) {
      onUpdate({ ...values, id: donation.id } as Donation);
    } else {
      onAdd(values);
    }
  };

  const formik = useFormik({
    initialValues: {
      foodItems: donation ? donation.foodItems : "",
      weight: donation ? donation.weight : 0,
      location: donation ? donation.location : "",
      instructions: donation ? donation.instructions : "",
      date: Date.now(),
      from: donation ? donation.from : "",
      until: donation ? donation.until : "",
      description: donation ? donation.description : "",
    },
    validationSchema: Yup.object({
      foodItems: Yup.string().required(t("common.validations.required")),
      description: Yup.string(),
      weight: Yup.number()
        .min(0, t("common.validations.invalid"))
        .required(t("common.validations.required")),
      location: Yup.string().required(t("common.validations.required")),
      instructions: Yup.string(),
      date: Yup.number().required(t("common.validations.required")),
      from: Yup.string().required(t("common.validations.required")),
      until: Yup.string().required(t("common.validations.required")),
    }),
    onSubmit: handleSubmit,
  });

  return (
    <Dialog
      open={open}
      onClose={onClose}
      aria-labelledby="donation-dialog-title"
    >
      <form onSubmit={formik.handleSubmit} noValidate>
        <DialogTitle id="donation-dialog-title">
          {editMode
            ? t("donationManagement.modal.edit.title")
            : t("donationManagement.modal.add.title")}
        </DialogTitle>

        <DialogContent>
          <TextField
            margin="normal"
            required
            fullWidth
            id="foodItems"
            label={t("donationManagement.form.foodItems.label")}
            name="foodItems"
            autoFocus
            disabled={processing}
            value={formik.values.foodItems}
            onChange={formik.handleChange}
            error={formik.touched.foodItems && Boolean(formik.errors.foodItems)}
            helperText={formik.touched.foodItems && formik.errors.foodItems}
          />
          <TextField
            margin="normal"
            required
            fullWidth
            id="description"
            label={t("donationManagement.form.description.label")}
            name="description"
            disabled={processing}
            value={formik.values.description}
            onChange={formik.handleChange}
            error={
              formik.touched.description && Boolean(formik.errors.description)
            }
            helperText={formik.touched.description && formik.errors.description}
          />
          <TextField
            margin="normal"
            required
            fullWidth
            id="weight"
            label={t("donationManagement.form.weight.label")}
            name="weight"
            type="number"
            disabled={processing}
            value={formik.values.weight}
            onChange={formik.handleChange}
            error={formik.touched.weight && Boolean(formik.errors.weight)}
            helperText={formik.touched.weight && formik.errors.weight}
          />
          <TextField
            margin="normal"
            required
            fullWidth
            id="location"
            label={t("donationManagement.form.location.label")}
            name="location"
            disabled={processing}
            value={formik.values.location}
            onChange={formik.handleChange}
            error={formik.touched.location && Boolean(formik.errors.location)}
            helperText={formik.touched.location && formik.errors.location}
          />
          <TextField
            margin="normal"
            required
            fullWidth
            id="instructions"
            label={t("donationManagement.form.instructions.label")}
            name="instructions"
            disabled={processing}
            value={formik.values.instructions}
            onChange={formik.handleChange}
            error={
              formik.touched.instructions && Boolean(formik.errors.instructions)
            }
            helperText={
              formik.touched.instructions && formik.errors.instructions
            }
          />
          <TextField
            margin="normal"
            required
            fullWidth
            id="from"
            label={t("donationManagement.form.from.label")}
            name="from"
            disabled={processing}
            value={formik.values.from}
            onChange={formik.handleChange}
            error={formik.touched.from && Boolean(formik.errors.from)}
            helperText={formik.touched.from && formik.errors.from}
          />
          <TextField
            margin="normal"
            required
            fullWidth
            id="until"
            label={t("donationManagement.form.until.label")}
            name="until"
            disabled={processing}
            value={formik.values.until}
            onChange={formik.handleChange}
            error={formik.touched.until && Boolean(formik.errors.until)}
            helperText={formik.touched.until && formik.errors.until}
          />
        </DialogContent>
        <DialogActions>
          <Button onClick={onClose}>{t("common.cancel")}</Button>
          <LoadingButton loading={processing} type="submit" variant="contained">
            {editMode
              ? t("donationManagement.modal.edit.action")
              : t("donationManagement.modal.add.action")}
          </LoadingButton>
        </DialogActions>
      </form>
    </Dialog>
  );
};

export default DonationDialog;
