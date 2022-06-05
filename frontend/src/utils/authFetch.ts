export default function authFetch(
  user: any,
  url: string,
  options: any
): Promise<Response> {
  // validate user token
  if (!user.token) {
    return Promise.reject(new Error("No token"));
  }
  // refresh user token if failed logout


  return fetch(url, {
    ...options,
    headers: {
      ...options.headers,
      Authorization: `Bearer ${user.token}`,
    },
  });
}

export function refreshToken(user: any): Promise<Response> {
  return authFetch(user, "/api/auth/refresh", {
    method: "POST",
  });
}
