import { ApolloServer } from "@apollo/server";

export function buildGraphqlServer() {
  return new ApolloServer({
    typeDefs: "#graphql\n type Query { health: String! }",
    resolvers: {
      Query: {
        health: () => "ok",
      },
    },
  });
}
