// CRC16-CCITT (poly 0x1021, init 0xFFFF)
export function crc16ccitt(input: string): number {
  let crc = 0xFFFF;
  for (let i = 0; i < input.length; i++) {
    crc ^= input.charCodeAt(i) << 8;
    for (let j = 0; j < 8; j++) {
      if (crc & 0x8000) crc = (crc << 1) ^ 0x1021;
      else crc <<= 1;
      crc &= 0xffff;
    }
  }
  return crc & 0xffff;
}

export function formatCrcHex(crc: number): string {
  return crc.toString(16).toUpperCase().padStart(4, '0');
}

// Parse top-level TLV into array of {tag,len,value} (value is raw string)
// Assumes ASCII payload
export function parseTLV(payload: string) {
  const out: { tag: string; len: number; value: string; }[] = [];
  let i = 0;
  while (i < payload.length) {
    const tag = payload.substr(i, 2); i += 2;
    const len = Number(payload.substr(i, 2)); i += 2;
    const val = payload.substr(i, len); i += len;
    out.push({ tag, len, value: val });
  }
  return out;
}

// Build TLV string from parsed array
export function buildTLV(parsed: { tag: string; value: string; }[]) {
  return parsed.map(p => `${p.tag}${String(p.value.length).padStart(2, '0')}${p.value}`).join('');
}

// Helper to find and remove the final CRC (tag 63), returning [baseWithoutCRC, crcValueOrNull]
export function stripCrc(payload: string): { base: string; crc: string | null; } {
  const idx = payload.indexOf('6304');
  if (idx === -1) return { base: payload, crc: null };
  const crc = payload.substr(idx + 4, 4);
  const base = payload.substring(0, idx);
  return { base, crc };
}

// Parse top-level, but keep sub-TLV content raw; useful for manipulating top-level tags
export function parseTopLevel(payload: string) {
  // strip CRC if any
  const { base } = stripCrc(payload);
  const arr = [];
  let i = 0;
  while (i < base.length) {
    const tag = base.substr(i, 2); i += 2;
    const len = Number(base.substr(i, 2)); i += 2;
    const val = base.substr(i, len); i += len;
    arr.push({ tag, len, value: val });
  }
  return arr; // array of {tag, len, value}
}

// Rebuild full payload with recomputed CRC
export function rebuildWithCrc(topLevelArr: { tag: string; value: string; }[]) {
  const base = buildTLV(topLevelArr);
  const with6304 = base + '6304';
  const crc = crc16ccitt(with6304);
  return with6304 + formatCrcHex(crc);
}

// Replace or set a top-level tag (immutable). If tag exists, replace its first occurrence.
// If not exists, insert before CRC (i.e., at the end of top-level array).
export function setTopLevelTag(originalPayload: string, tag: string, value: string) {
  value = value.length > 25 ? `${value.slice(0, 22)}...` : value; // max 25 chars for value

  const top = parseTopLevel(originalPayload);
  // copy
  const copy = top.map(t => ({ tag: t.tag, value: t.value }));
  const idx = copy.findIndex(t => t.tag === tag);
  if (idx >= 0) {
    copy[idx] = { tag, value };
  } else {
    // insert before CRC -> means append to end of top-level tags
    copy.push({ tag, value });
  }
  return rebuildWithCrc(copy);
}

// Insert / replace amount using top-level setter. amountStr should be like "15000" or "12345.67"
export function insertAmount(originalPayload: string, amount: string | number) {
  const amountStr = typeof amount === 'number' ? String(amount) : amount;
  if (!/^\d+(\.\d+)?$/.test(amountStr)) {
    throw new Error("Amount must be numeric or numeric with decimal point (e.g. '15000' or '12345.67')");
  }
  return setTopLevelTag(originalPayload, '54', amountStr);
}

// Helpers to parse sub-TLV inside tag 62 (or 26-51) - return array of {tag,len,value}
export function parseSubTlv(raw: string) {
  const out: { tag: string; value: string; }[] = [];
  let i = 0;
  while (i < raw.length) {
    const tag = raw.substr(i, 2); i += 2;
    const len = Number(raw.substr(i, 2)); i += 2;
    const val = raw.substr(i, len); i += len;
    out.push({ tag, value: val });
  }
  return out;
}

export function buildSubTlv(subs: { tag: string; value: string; }[]) {
  return subs.map(s => `${s.tag}${String(s.value.length).padStart(2, '0')}${s.value}`).join('');
}

// Set/add a sub-TLV under top-level tag 62 (Additional Data). If 62 missing, create it.
// subTag like "09", value is string.
export function set62SubTag(originalPayload: string, subTag: string, subValue: string) {
  const top = parseTopLevel(originalPayload);
  // find 62
  const copy = top.map(t => ({ tag: t.tag, value: t.value }));
  const idx62 = copy.findIndex(t => t.tag === '62');
  if (idx62 >= 0) {
    const subs = parseSubTlv(copy[idx62]!.value);
    const idxSub = subs.findIndex(s => s.tag === subTag);
    if (idxSub >= 0) subs[idxSub]!.value = subValue;
    else subs.push({ tag: subTag, value: subValue });
    copy[idx62]!.value = buildSubTlv(subs);
  } else {
    // insert new 62 before the end
    copy.push({ tag: '62', value: buildSubTlv([{ tag: subTag, value: subValue }]) });
  }
  return rebuildWithCrc(copy);
}
