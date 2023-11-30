import {
  Delete as DeleteIcon,
  Edit as EditIcon,
  MoreVert as MoreVertIcon,
  Photo as PhotoIcon,
} from "@mui/icons-material";
import {
  Box,
  Checkbox,
  Chip,
  IconButton,
  ListItemIcon,
  Menu,
  MenuItem,
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TablePagination,
  TableRow,
  Typography,
} from "@mui/material";
import React, { useState } from "react";
import { useTranslation } from "react-i18next";
import Empty from "../../core/components/Empty";
import * as selectUtils from "../../core/utils/selectUtils";
import { Donation } from "../types/donation";

interface HeadCell {
  id: string;
  label: string;
  align: "center" | "left" | "right";
}

const headCells: HeadCell[] = [
  {
    id: "donation",
    align: "left",
    label: "donationManagement.table.headers.donation",
  },
  {
    id: "date",
    align: "center",
    label: "donationManagement.table.headers.date",
  },
  {
    id: "status",
    align: "center",
    label: "donationManagement.table.headers.status",
  },
];

interface EnhancedTableProps {
  numSelected: number;
  onSelectAllClick: (event: React.ChangeEvent<HTMLInputElement>) => void;
  rowCount: number;
}

function EnhancedTableHead({
  onSelectAllClick,
  numSelected,
  rowCount,
}: EnhancedTableProps) {
  const { t } = useTranslation();

  return (
    <TableHead>
      <TableRow sx={{ "& th": { border: 0 } }}>
        <TableCell sx={{ py: 0 }}>
          <Checkbox
            color="primary"
            indeterminate={numSelected > 0 && numSelected < rowCount}
            checked={rowCount > 0 && numSelected === rowCount}
            onChange={onSelectAllClick}
            inputProps={{
              "aria-label": "select all donations",
            }}
          />
        </TableCell>
        {headCells.map((headCell) => (
          <TableCell key={headCell.id} align={headCell.align} sx={{ py: 0 }}>
            {t(headCell.label)}
          </TableCell>
        ))}
        <TableCell align="right" sx={{ py: 0 }}>
          {t("donationManagement.table.headers.actions")}
        </TableCell>
      </TableRow>
    </TableHead>
  );
}

type DonationRowProps = {
  index: number;
  onCheck: (id: string) => void;
  onDelete: (donationIds: string[]) => void;
  onEdit: (donation: Donation) => void;
  processing: boolean;
  selected: boolean;
  donation: Donation;
};

const DonationRow = ({
  index,
  onCheck,
  onDelete,
  onEdit,
  processing,
  selected,
  donation,
}: DonationRowProps) => {
  const [anchorEl, setAnchorEl] = useState<null | HTMLElement>(null);
  const { t } = useTranslation();

  const labelId = `enhanced-table-checkbox-${index}`;
  const openActions = Boolean(anchorEl);

  const handleOpenActions = (event: React.MouseEvent<HTMLButtonElement>) => {
    setAnchorEl(event.currentTarget);
  };

  const handleCloseActions = () => {
    setAnchorEl(null);
  };

  const handleDelete = () => {
    handleCloseActions();
    onDelete([donation.id]);
  };

  const handleEdit = () => {
    handleCloseActions();
    onEdit(donation);
  };

  return (
    <TableRow
      aria-checked={selected}
      tabIndex={-1}
      key={donation.id}
      selected={selected}
      sx={{ "& td": { bgcolor: "background.paper", border: 0 } }}
    >
      <TableCell
        padding="checkbox"
        sx={{ borderTopLeftRadius: "1rem", borderBottomLeftRadius: "1rem" }}
      >
        <Checkbox
          color="primary"
          checked={selected}
          inputProps={{
            "aria-labelledby": labelId,
          }}
          onClick={() => onCheck(donation.id)}
        />
      </TableCell>
      <TableCell>
        <Box sx={{ display: "flex", alignItems: "center" }}>
          <PhotoIcon sx={{ mr: 3, fontSize: "2.5rem" }} />
          <Box>
            <Typography component="div" variant="h6">
              {donation.foodItems}
            </Typography>
            <Typography color="textSecondary" variant="body2">
              {donation.description}
            </Typography>
          </Box>
        </Box>
      </TableCell>
      <TableCell align="center">
        {new Date(donation.date).toISOString()}
      </TableCell>
      <TableCell align="center">
        {donation.active ? (
          <Chip color="primary" label="Active" />
        ) : (
          <Chip label="Fullfielded" />
        )}
      </TableCell>
      <TableCell
        align="right"
        sx={{ borderTopRightRadius: "1rem", borderBottomRightRadius: "1rem" }}
      >
        <IconButton
          id="donation-row-menu-button"
          aria-label="donation actions"
          aria-controls="donation-row-menu"
          aria-haspopup="true"
          aria-expanded={openActions ? "true" : "false"}
          disabled={processing}
          onClick={handleOpenActions}
        >
          <MoreVertIcon />
        </IconButton>
        <Menu
          id="donation-row-menu"
          anchorEl={anchorEl}
          aria-labelledby="donation-row-menu-button"
          open={openActions}
          onClose={handleCloseActions}
          anchorOrigin={{
            vertical: "top",
            horizontal: "right",
          }}
          transformOrigin={{
            vertical: "top",
            horizontal: "right",
          }}
        >
          <MenuItem onClick={handleEdit}>
            <ListItemIcon>
              <EditIcon />
            </ListItemIcon>{" "}
            {t("common.edit")}
          </MenuItem>
          <MenuItem onClick={handleDelete}>
            <ListItemIcon>
              <DeleteIcon />
            </ListItemIcon>{" "}
            {t("common.delete")}
          </MenuItem>
        </Menu>
      </TableCell>
    </TableRow>
  );
};

type DonationTableProps = {
  processing: boolean;
  onDelete: (donationIds: string[]) => void;
  onEdit: (donation: Donation) => void;
  onSelectedChange: (selected: string[]) => void;
  selected: string[];
  donations?: Donation[];
};

const DonationTable = ({
  onDelete,
  onEdit,
  onSelectedChange,
  processing,
  selected,
  donations = [],
}: DonationTableProps) => {
  const [page, setPage] = useState(0);
  const [rowsPerPage, setRowsPerPage] = useState(5);

  const handleSelectAllClick = (event: React.ChangeEvent<HTMLInputElement>) => {
    if (event.target.checked) {
      const newSelecteds = selectUtils.selectAll(donations);
      onSelectedChange(newSelecteds);
      return;
    }
    onSelectedChange([]);
  };

  const handleClick = (id: string) => {
    let newSelected: string[] = selectUtils.selectOne(selected, id);
    onSelectedChange(newSelected);
  };

  const handleChangePage = (event: unknown, newPage: number) => {
    setPage(newPage);
  };

  const handleChangeRowsPerPage = (
    event: React.ChangeEvent<HTMLInputElement>
  ) => {
    setRowsPerPage(parseInt(event.target.value, 10));
    setPage(0);
  };

  const isSelected = (id: string) => selected.indexOf(id) !== -1;

  if (donations.length === 0) {
    return <Empty title="No donation yet" />;
  }

  return (
    <React.Fragment>
      <TableContainer>
        <Table
          aria-labelledby="tableTitle"
          sx={{
            minWidth: 600,
            borderCollapse: "separate",
            borderSpacing: "0 1rem",
          }}
        >
          <EnhancedTableHead
            numSelected={selected.length}
            onSelectAllClick={handleSelectAllClick}
            rowCount={donations.length}
          />
          <TableBody>
            {donations
              .slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)
              .map((donation, index) => (
                <DonationRow
                  index={index}
                  key={donation.id}
                  onCheck={handleClick}
                  onDelete={onDelete}
                  onEdit={onEdit}
                  processing={processing}
                  selected={isSelected(donation.id)}
                  donation={donation}
                />
              ))}
          </TableBody>
        </Table>
      </TableContainer>
      <TablePagination
        rowsPerPageOptions={[5, 10, 25]}
        component="div"
        count={donations.length}
        rowsPerPage={rowsPerPage}
        page={page}
        onPageChange={handleChangePage}
        onRowsPerPageChange={handleChangeRowsPerPage}
      />
    </React.Fragment>
  );
};

export default DonationTable;
