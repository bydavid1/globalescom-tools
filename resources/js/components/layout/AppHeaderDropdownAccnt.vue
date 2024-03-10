<template>
    <CDropdown variant="nav-item">
        <CDropdownToggle placement="bottom-end" :caret="false">
            <CIcon icon="cil-user" size="lg" />
        </CDropdownToggle>
        <CDropdownMenu class="pt-0">
            <CDropdownHeader component="h6" class="bg-light fw-semibold py-2">
                Account
            </CDropdownHeader>
            <CDropdownItem>
                <CIcon icon="cil-bell" /> Alertas
                <CBadge color="info" class="ms-auto">{{ itemsCount }}</CBadge>
            </CDropdownItem>
            <CDropdownHeader component="h6" class="bg-light fw-semibold py-2">
                Settings
            </CDropdownHeader>
            <CDropdownItem>
                <CIcon icon="cil-user" /> Cuenta
            </CDropdownItem>
            <CDropdownItem>
                <CIcon icon="cil-settings" /> Configuracion
            </CDropdownItem>
            <CDropdownDivider />
            <CDropdownItem style="cursor: pointer;" @click="endSession">
                <CIcon icon="cil-lock-locked" /> Cerrar Sesion
            </CDropdownItem>
        </CDropdownMenu>
    </CDropdown>
</template>

<script setup>
import CIcon from '@coreui/icons-vue';
import { logout } from '../../services/api/auth-service';

const itemsCount = 5;

const endSession = async () => {
    await logout();
    window.location.href = '/';
};
</script>
