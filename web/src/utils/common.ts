export const getWhatsAppLink = (phoneNumber: string, text?: string) => {
  const internationalNumber = phoneNumber.startsWith('08')
    ? `62${phoneNumber.substring(1)}`
    : phoneNumber;
  return `https://wa.me/${internationalNumber}?text=${encodeURIComponent(text || '')}`;
};
