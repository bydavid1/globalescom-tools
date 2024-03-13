<template>
    <CDropdown variant="nav-item">
        <CDropdownToggle placement="bottom-end" :caret="false">
            <CIcon icon="cil-user" size="lg" />
        </CDropdownToggle>
        <CDropdownMenu class="pt-1">
            <CDropdownItem style="cursor: pointer;" @click="endSession">
                <CIcon icon="cil-lock-locked" /> Cerrar Sesion
            </CDropdownItem>
        </CDropdownMenu>
    </CDropdown>
</template>

<script setup>
import CIcon from '@coreui/icons-vue';
import { logout } from '../../services/api/auth-service';

const endSession = async () => {
    await logout();
    window.location.href = '/';
};
</script>
