import { TypeOrmDataSourceLike } from "../db";

export interface OrderLine {
  sku: string;
  warehouseId: number;
  quantity: number;
}

export class InventoryRepository {
  constructor(private readonly dataSource: TypeOrmDataSourceLike) {}

  async checkStockForOrder(lines: OrderLine[]) {
    const stockRows = [];

    for (const line of lines) {
      // queryid: Q1-7b6a3d9f
      const sql = `SELECT sku, available_quantity FROM inventory WHERE sku = '${line.sku}' AND warehouse_id = ${line.warehouseId};`;
      const [row] = await this.dataSource.query(sql);
      stockRows.push({ ...row, requestedQuantity: line.quantity });
    }

    return stockRows;
  }
}
