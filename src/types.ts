/* eslint-disable no-unused-vars */
/* eslint-disable @typescript-eslint/no-namespace */
import type { QTable } from 'quasar';

export namespace q {
  export type Table = QTable;

  export namespace Table {
    export type ColumnDefinition<T = Record<string, unknown>> = Omit<
      NonNullable<QTable['columns']>[number],
      'field' | 'format' | 'sort' | 'name' | 'align'
    > & {
      name: keyof T | string;
      field: ((row: T) => string) | keyof T;
      format?: (val: T[keyof T], row: T) => string;
      sort?: (a: T[keyof T], b: T[keyof T], rowA: T, rowB: T) => number;
      align?: 'left' | 'center' | 'right';
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
