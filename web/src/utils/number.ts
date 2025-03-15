export const currencyFmt = new Intl.NumberFormat('id-ID', {
  style: 'currency',
  currency: 'IDR',
});

export const toRoman = (num: number) => {
  const romanNumerals = [
    { value: 1000, symbol: 'M' },
    { value: 900, symbol: 'CM' },
    { value: 500, symbol: 'D' },
    { value: 400, symbol: 'CD' },
    { value: 100, symbol: 'C' },
    { value: 90, symbol: 'XC' },
    { value: 50, symbol: 'L' },
    { value: 40, symbol: 'XL' },
    { value: 10, symbol: 'X' },
    { value: 9, symbol: 'IX' },
    { value: 5, symbol: 'V' },
    { value: 4, symbol: 'IV' },
    { value: 1, symbol: 'I' },
  ];

  return romanNumerals.reduce((roman, pair) => {
    while (num >= pair.value) {
      roman += pair.symbol;
      num -= pair.value;
    }
    return roman;
  }, '');
};

type Units = Record<string, number>;

const DEFAULT_DATE_TIME_UNITS: Units = {
  year: 365 * 24 * 60 * 60 * 1000,
  month: 30 * 24 * 60 * 60 * 1000,
  day: 24 * 60 * 60 * 1000,
  hour: 60 * 60 * 1000,
  minute: 60 * 1000,
  second: 1000,
};

export const toDateTimeUnit = (ms: number, units: Units = DEFAULT_DATE_TIME_UNITS) => {
  const dateTime = Object.entries(units).reduce((acc, [unit, value]) => {
    const count = Math.floor(ms / value);
    if (count > 0) {
      acc[unit] = count;
      ms -= count * value;
    }
    return acc;
  }, {} as Record<string, number>);

  return {
    ...dateTime,
    toString() {
      return Object.entries(dateTime)
        .sort((a, b) => units[b[0]] - units[a[0]])
        .map(([unit, value]) => `${value} ${unit}`)
        .join(', ');
    },
  };
};

export const toIndonesianWords = (number: number) => {
  const units = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
  const teens = ['sepuluh', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'];
  const tens = ['', '', 'dua puluh', 'tiga puluh', 'empat puluh', 'lima puluh', 'enam puluh', 'tujuh puluh', 'delapan puluh', 'sembilan puluh'];
  const thousands = ['', 'ribu', 'juta', 'miliar', 'triliun'];

  const convertHundreds = (num: number) => {
    let words = '';
    if (num > 99) {
      if (num === 100) {
        words += 'seratus ';
      } else {
        words += `${units[Math.floor(num / 100)]} ratus `;
      }
      num %= 100;
    }
    if (num > 19) {
      words += `${tens[Math.floor(num / 10)]} `;
      num %= 10;
    }
    if (num > 0 && num < 10) {
      words += `${units[num]} `;
    } else if (num >= 10 && num < 20) {
      words += `${teens[num - 10]} `;
    }
    return words.trim();
  };

  if (number === 0) return 'nol';

  let word = '';
  let level = 0;

  while (number > 0) {
    const remainder = number % 1000;
    if (remainder > 0) {
      if (remainder === 1 && level === 1) {
        word = `seribu ${word}`;
      } else {
        word = `${convertHundreds(remainder)} ${thousands[level]} ${word}`;
      }
    }
    number = Math.floor(number / 1000);
    level += 1;
  }

  return word.trim();
};
