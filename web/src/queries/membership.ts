import { useQuery } from '@tanstack/vue-query';
import { membershipApi } from 'src/services/v2/membership';
import { toValue, type MaybeRefOrGetter } from 'vue';

export const useMembership = (id: string) => useQuery({
  queryKey: ['membership', id],
  queryFn: () => membershipApi.get(id),
});

export const useMembershipInvoices = (membershipId: MaybeRefOrGetter<string>) => useQuery({
  queryKey: ['membership', membershipId, 'invoices'],
  queryFn: () => membershipApi.invoicesOf(toValue(membershipId)),
  enabled: () => !!toValue(membershipId),
  placeholderData: [],
  initialData: [],
});
