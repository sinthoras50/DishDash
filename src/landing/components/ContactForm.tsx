import { LoadingButton } from "@mui/lab";
import { Box, TextField } from "@mui/material";
import { useFormik } from "formik";
import { useTranslation } from "react-i18next";
import * as Yup from "yup";
import { useSnackbar } from "../../core/contexts/SnackbarProvider";
import { useSendMessage } from "../../core/hooks/useSendMessage";

const ContactForm = () => {
  const { t } = useTranslation();
  const snackbar = useSnackbar();
  const { sendMessage, isSending } = useSendMessage();

  const validationSchema = Yup.object({
    email: Yup.string()
      .email(t("common.validations.email"))
      .required(t("common.validations.required")),
    message: Yup.string().required(t("common.validations.required")),
  });

  type FormData = Yup.InferType<typeof validationSchema>;

  const handleSendMessage = async (data: FormData) => {
    try {
      await sendMessage(data);
      snackbar.success(t("landing.notifications.formSubmitted"));
      formik.resetForm();
    } catch {
      snackbar.error(t("common.errors.unexpected.subTitle"));
    }
  };

  const formik = useFormik({
    initialValues: {
      email: "",
      message: "",
    },
    validationSchema,
    onSubmit: handleSendMessage,
  });

  return (
    <Box component="form" noValidate onSubmit={formik.handleSubmit}>
      <TextField
        margin="normal"
        variant="filled"
        required
        fullWidth
        id="email"
        label={t("landing.getInTouch.form.email.label")}
        name="email"
        autoComplete="email"
        disabled={isSending}
        value={formik.values.email}
        onChange={formik.handleChange}
        error={formik.touched.email && Boolean(formik.errors.email)}
        helperText={formik.touched.email && formik.errors.email}
      />
      <TextField
        margin="normal"
        variant="filled"
        multiline
        rows={4}
        required
        fullWidth
        name="message"
        label={t("landing.getInTouch.form.message.label")}
        id="message"
        disabled={isSending}
        value={formik.values.message}
        onChange={formik.handleChange}
        error={formik.touched.message && Boolean(formik.errors.message)}
        helperText={formik.touched.message && formik.errors.message}
      />
      <LoadingButton
        type="submit"
        loading={isSending}
        variant="contained"
        sx={{ mt: 3, alignSelf: "flex-end" }}
      >
        {t("landing.getInTouch.form.submit")}
      </LoadingButton>
    </Box>
  );
};

export default ContactForm;
