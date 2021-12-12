/* eslint-disable @typescript-eslint/no-namespace */
import type { QTableProps } from 'quasar';
import type { LooseDictionary } from 'src/types/common';

export namespace q {
  export namespace Table {
    export type ColumnOrig = NonNullable<QTableProps['columns']>[number];

    export interface ColumnDefinition<T = LooseDictionary> extends Omit<
      NonNullable<QTableProps['columns']>[number],
      'name' | 'field' | 'format' | 'sort'
    > {
      name: keyof T | string;
      field: ((row: T) => string) | keyof T;
      format?: (val: T[keyof T], row: T) => string;
      sort?: (a: T[keyof T], b: T[keyof T], rowA: T, rowB: T) => number;
    }

    // https://quasar.dev/vue-components/table#qtable-api > scopedslots > body-cell-[name]
    export type BodyCellNamed<T> = {
      col: q.Table.ColumnDefinition<T>;
      value: unknown;
      key: string;
      row: T;
      rowIndex: number;
      pageIndex: number;
      cols: q.Table.ColumnDefinition<T>[];
      colsMap: Record<keyof T, q.Table.ColumnDefinition<T>>;
      sort: (colName: string) => void;
      selected: boolean;
      expand: boolean;
      color: string;
      dark: boolean;
      dense: boolean;
    }
  }
}
