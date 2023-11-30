import { Add as AddIcon } from "@mui/icons-material";
import { Fab } from "@mui/material";
import React, { useState } from "react";
import { useTranslation } from "react-i18next";
import AdminAppBar from "../../admin/components/AdminAppBar";
import AdminToolbar from "../../admin/components/AdminToolbar";
import ConfirmDialog from "../../core/components/ConfirmDialog";
import SelectToolbar from "../../core/components/SelectToolbar";
import { useSnackbar } from "../../core/contexts/SnackbarProvider";
import DonationDialog from "../components/DonationDialog";
import DonationTable from "../components/DonationTable";
import { useAddDonation } from "../hooks/useAddDonation";
import { useDeleteDonations } from "../hooks/useDeleteDonations";
import { useDonations } from "../hooks/useDonations";
import { useUpdateDonation } from "../hooks/useUpdateDonation";
import { Donation } from "../types/donation";

const DonationManagement = () => {
  const snackbar = useSnackbar();
  const { t } = useTranslation();

  const [openConfirmDeleteDialog, setOpenConfirmDeleteDialog] = useState(false);
  const [openDonationDialog, setOpenDonationDialog] = useState(false);
  const [selected, setSelected] = useState<string[]>([]);
  const [donationDeleted, setDonationDeleted] = useState<string[]>([]);
  const [donationUpdated, setDonationUpdated] = useState<Donation | undefined>(
    undefined
  );

  const { addDonation, isAdding } = useAddDonation();
  const { deleteDonations, isDeleting } = useDeleteDonations();
  const { isUpdating, updateDonation } = useUpdateDonation();
  const { data } = useDonations();

  const processing = isAdding || isDeleting || isUpdating;

  const handleAddDonation = async (donation: Partial<Donation>) => {
    try {
      await addDonation(donation as Donation);
      snackbar.success(
        t("donationManagement.notifications.addSuccess", {
          donation: donation.foodItems,
        })
      );
      setOpenDonationDialog(false);
    } catch (err: any) {
      snackbar.error(t("common.errors.unexpected.subTitle"));
    }
  };

  const handleDeleteDonations = async () => {
    try {
      await deleteDonations(donationDeleted);
      snackbar.success(t("donationManagement.notifications.deleteSuccess"));
      setSelected([]);
      setDonationDeleted([]);
      setOpenConfirmDeleteDialog(false);
    } catch (err: any) {
      snackbar.error(t("common.errors.unexpected.subTitle"));
    }
  };

  const handleUpdateDonation = async (donation: Donation) => {
    try {
      await updateDonation(donation);
      snackbar.success(
        t("donationManagement.notifications.updateSuccess", {
          donation: donation.foodItems,
        })
      );
      setOpenDonationDialog(false);
    } catch (err: any) {
      snackbar.error(t("common.errors.unexpected.subTitle"));
    }
  };

  const handleCancelSelected = () => {
    setSelected([]);
  };

  const handleCloseConfirmDeleteDialog = () => {
    setOpenConfirmDeleteDialog(false);
  };

  const handleCloseDonationDialog = () => {
    setDonationUpdated(undefined);
    setOpenDonationDialog(false);
  };

  const handleOpenConfirmDeleteDialog = (donationIds: string[]) => {
    setDonationDeleted(donationIds);
    setOpenConfirmDeleteDialog(true);
  };

  const handleOpenDonationDialog = (donation?: Donation) => {
    setDonationUpdated(donation);
    setOpenDonationDialog(true);
  };

  const handleSelectedChange = (newSelected: string[]) => {
    setSelected(newSelected);
  };

  return (
    <React.Fragment>
      <AdminAppBar>
        {!selected.length ? (
          <AdminToolbar title={t("donationManagement.toolbar.title")}>
            <Fab
              aria-label="logout"
              color="primary"
              disabled={processing}
              onClick={() => handleOpenDonationDialog()}
              size="small"
            >
              <AddIcon />
            </Fab>
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
        onEdit={handleOpenDonationDialog}
        onSelectedChange={handleSelectedChange}
        selected={selected}
        donations={data}
      />
      <ConfirmDialog
        description={t("donationManagement.confirmations.delete")}
        pending={processing}
        onClose={handleCloseConfirmDeleteDialog}
        onConfirm={handleDeleteDonations}
        open={openConfirmDeleteDialog}
        title={t("common.confirmation")}
      />
      {openDonationDialog && (
        <DonationDialog
          onAdd={handleAddDonation}
          onClose={handleCloseDonationDialog}
          onUpdate={handleUpdateDonation}
          open={openDonationDialog}
          processing={processing}
          donation={donationUpdated}
        />
      )}
    </React.Fragment>
  );
};

export default DonationManagement;
