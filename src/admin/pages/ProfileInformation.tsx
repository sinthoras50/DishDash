import { LoadingButton } from "@mui/lab";
import {
  Button,
  Card,
  CardActions,
  CardContent,
  CardHeader,
  TextField,
} from "@mui/material";
import { useFormik } from "formik";
import { useTranslation } from "react-i18next";
import * as Yup from "yup";
import { useAuth } from "../../auth/contexts/AuthProvider";
import { UserInfo } from "../../auth/types/userInfo";
import { useSnackbar } from "../../core/contexts/SnackbarProvider";
import { useUpdateUserInfo } from "../hooks/updateUserInfo";

const ProfileInformation = () => {
  const snackbar = useSnackbar();
  const { t } = useTranslation();

  const { userInfo } = useAuth();
  const { isUpdating, updateUserInfo } = useUpdateUserInfo();

  const phoneReg = /^\+(?:[0-9] ?){6,14}[0-9]$/;

  const formik = useFormik({
    initialValues: {
      firstName: userInfo ? userInfo.firstName : "",
      lastName: userInfo ? userInfo.lastName : "",
      email: userInfo ? userInfo.email : "",
      phone: userInfo ? userInfo.phone : "",
    },
    validationSchema: Yup.object({
      firstName: Yup.string()
        .max(20, t("common.validations.max", { size: 20 }))
        .required(t("common.validations.required")),
      lastName: Yup.string()
        .max(30, t("common.validations.max", { size: 30 }))
        .required(t("common.validations.required")),
      email: Yup.string()
        .email(t("common.validations.email"))
        .required(t("common.validations.required")),
      phone: Yup.string()
        .matches(phoneReg, t("common.validations.phone"))
        .required(t("common.validations.required")),
    }),
    onSubmit: (values) => handleSubmit(values),
  });

  const handleSubmit = async (values: Partial<UserInfo>) => {
    try {
      await updateUserInfo({
        ...values,
        id: userInfo?.id,
        token: userInfo?.token,
      } as UserInfo);
      snackbar.success(t("profile.notifications.informationUpdated"));
    } catch (err: any) {
      snackbar.error(t("common.errors.unexpected.subTitle"));
    }
  };

  return (
    <form onSubmit={formik.handleSubmit} noValidate>
      <Card>
        <CardHeader title={t("profile.info.title")} />
        <CardContent>
          <TextField
            margin="normal"
            required
            autoFocus
            fullWidth
            id="firstName"
            label={t("profile.info.form.firstName.label")}
            name="firstName"
            autoComplete="given-name"
            disabled={isUpdating}
            value={formik.values.firstName}
            onChange={formik.handleChange}
            error={formik.touched.firstName && Boolean(formik.errors.firstName)}
            helperText={formik.touched.firstName && formik.errors.firstName}
          />
          <TextField
            margin="normal"
            required
            fullWidth
            id="lastName"
            label={t("profile.info.form.lastName.label")}
            name="lastName"
            autoComplete="family-name"
            disabled={isUpdating}
            value={formik.values.lastName}
            onChange={formik.handleChange}
            error={formik.touched.lastName && Boolean(formik.errors.lastName)}
            helperText={formik.touched.lastName && formik.errors.lastName}
          />
          <TextField
            margin="normal"
            required
            fullWidth
            id="email"
            label={t("profile.info.form.email.label")}
            name="email"
            autoComplete="email"
            disabled={isUpdating}
            value={formik.values.email}
            onChange={formik.handleChange}
            error={formik.touched.email && Boolean(formik.errors.email)}
            helperText={formik.touched.email && formik.errors.email}
          />
          <TextField
            margin="normal"
            required
            fullWidth
            id="phone"
            label={t("profile.info.form.phone.label")}
            name="phone"
            autoComplete="tel"
            disabled={isUpdating}
            value={formik.values.phone}
            onChange={formik.handleChange}
            error={formik.touched.phone && Boolean(formik.errors.phone)}
            helperText={formik.touched.phone && formik.errors.phone}
          />
        </CardContent>
        <CardActions>
          <Button onClick={() => formik.resetForm()}>
            {t("common.reset")}
          </Button>
          <LoadingButton loading={isUpdating} type="submit" variant="contained">
            {t("common.update")}
          </LoadingButton>
        </CardActions>
      </Card>
    </form>
  );
};

export default ProfileInformation;
