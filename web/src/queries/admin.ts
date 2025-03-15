import { useMutation, useQuery, useQueryClient } from '@tanstack/vue-query';
import { adminApi } from 'src/services/v2/admin';

interface AttachMembershipRequestToInvoicePayload {
  invoiceId: string;
  membershipRequestId: string;
}

export const useAdminMembershipRequestsStates = () => useQuery({
  queryKey: ['admin', 'membership-requests-states'],
  queryFn: () => adminApi.getMembershipRequestStates(),
  placeholderData: [],
});

export const useAttachMembershipRequestToInvoice = () => {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: ({ invoiceId, membershipRequestId }: AttachMembershipRequestToInvoicePayload) => adminApi
      .attachMembershipRequestToInvoice(invoiceId, membershipRequestId),
    onSuccess: () => {
      queryClient.invalidateQueries({
        queryKey: ['admin', 'membership-requests-states'],
      });
    },
  });
};
