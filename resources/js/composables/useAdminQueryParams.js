import { ref } from 'vue';
import { useRoute } from 'vue-router';

export default function useAdminQueryParams() {
  const showAsAdmin = ref(false);
  const companyId = ref(null);
  const route = useRoute();

  const validateQueryParams = () => {
    const query = route.query;

    if (query && query.asAdmin === 'true' && query.companyId) {
        showAsAdmin.value = true;
      companyId.value = query.companyId;
    }
  };

  return {
    showAsAdmin,
    companyId,
    validateQueryParams
  };
};
