export type QueryResult<T = unknown> = { rows: T[] };

export interface DbClient {
  query<T = unknown>(sql: string, params?: unknown[]): Promise<QueryResult<T>>;
}

export interface PrismaClientLike {
  $queryRawUnsafe<T = unknown>(sql: string): Promise<T>;
}

export interface TypeOrmDataSourceLike {
  query<T = unknown>(sql: string, params?: unknown[]): Promise<T[]>;
}

export interface KnexLike {
  raw<T = unknown>(sql: string): Promise<{ rows: T[] }>;
}
