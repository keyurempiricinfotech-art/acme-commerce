import { TypeOrmDataSourceLike } from "../db";

export class CategoryRepository {
  constructor(private readonly dataSource: TypeOrmDataSourceLike) {}

  async getTree() {
    // queryid: Q10-a2f79c80
    const sql = "WITH RECURSIVE tree AS (SELECT id, parent_id, name, 1 AS depth FROM categories WHERE parent_id IS NULL UNION ALL SELECT c.id, c.parent_id, c.name, t.depth + 1 FROM categories c JOIN tree t ON c.parent_id = t.id) SELECT * FROM tree ORDER BY depth, name;";
    return this.dataSource.query(sql);
  }
}
