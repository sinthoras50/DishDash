import { Add as AddIcon } from "@mui/icons-material";
import { Button } from "@mui/material";
import React, { useState } from "react";
import { useTranslation } from "react-i18next";
import { useNavigate } from "react-router";
import AdminAppBar from "../../admin/components/AdminAppBar";
import AdminToolbar from "../../admin/components/AdminToolbar";
import ConfirmDialog from "../../core/components/ConfirmDialog";
import SelectToolbar from "../../core/components/SelectToolbar";
import { useSnackbar } from "../../core/contexts/SnackbarProvider";
import DonationTable from "../components/DonationTable";
import { useDeleteDonations } from "../hooks/useDeleteDonations";
import { useDonations } from "../hooks/useDonations";

const DonationManagement = () => {
  const snackbar = useSnackbar();
  const { t } = useTranslation();
  const navigate = useNavigate();
  const [openConfirmDeleteDialog, setOpenConfirmDeleteDialog] = useState(false);
  const [selected, setSelected] = useState<string[]>([]);
  const [donationDeleted, setDonationDeleted] = useState<string[]>([]);
  const { deleteDonations, isDeleting } = useDeleteDonations();
  const { data } = useDonations();

  const processing = isDeleting;

  const handleDeleteDonations = async () => {
    try {
      await deleteDonations(donationDeleted);
      snackbar.success(
        t("donor.donationManagement.notifications.deleteSuccess")
      );
      setSelected([]);
      setDonationDeleted([]);
      setOpenConfirmDeleteDialog(false);
    } catch (err: any) {
      snackbar.error(t("common.errors.unexpected.subTitle"));
    }
  };

  const handleCancelSelected = () => {
    setSelected([]);
  };

  const handleEditDonation = (donationId: string) => {
    navigate(`/${process.env.PUBLIC_URL}/donor/donations/edit/${donationId}`);
  };

  const handleRepeatDonation = (donationId: string) => {
    navigate(`/${process.env.PUBLIC_URL}/donor/donations/repeat/${donationId}`);
  };

  const handleAddDonation = () => {
    navigate(`/${process.env.PUBLIC_URL}/donor/donations/new`);
  };

  const handleCloseConfirmDeleteDialog = () => {
    setOpenConfirmDeleteDialog(false);
  };

  const handleOpenConfirmDeleteDialog = (donationIds: string[]) => {
    setDonationDeleted(donationIds);
    setOpenConfirmDeleteDialog(true);
  };

  const handleSelectedChange = (newSelected: string[]) => {
    setSelected(newSelected);
  };

  return (
    <React.Fragment>
      <AdminAppBar>
        {!selected.length ? (
          <AdminToolbar title={t("donor.donationManagement.title")}>
            <Button
              variant="contained"
              startIcon={<AddIcon />}
              disabled={processing}
              onClick={handleAddDonation}
              size="small"
            >
              {t("donor.donationManagement.addDonation")}
            </Button>
          </AdminToolbar>
        ) : (
          <SelectToolbar
            processing={processing}
            onCancel={handleCancelSelected}
            onDelete={handleOpenConfirmDeleteDialog}
            selected={selected}
          />
        )}
      </AdminAppBar>
      <DonationTable
        processing={processing}
        onDelete={handleOpenConfirmDeleteDialog}
        onEdit={handleEditDonation}
        onRepeat={handleRepeatDonation}
        onSelectedChange={handleSelectedChange}
        selected={selected}
        donations={data}
      />
      <ConfirmDialog
        description={t("donor.donationManagement.confirmations.delete")}
        pending={processing}
        onClose={handleCloseConfirmDeleteDialog}
        onConfirm={handleDeleteDonations}
        open={openConfirmDeleteDialog}
        title={t("common.confirmation")}
      />
    </React.Fragment>
  );
};

export default DonationManagement;
