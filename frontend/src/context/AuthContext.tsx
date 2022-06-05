import React from "react";

interface AuthContextType {
  isAuthenticated: boolean;
  user: any;
  login: (user: any) => void;
  logout: () => void;
}

export let AuthContext = React.createContext<AuthContextType>(null!);

export function AuthProvider({ children }: { children: React.ReactNode }) {
  const [isAuthenticated, setIsAuthenticated] = React.useState(false);
  const [user, setUser] = React.useState<any>(null);

  const login = (user: any) => {
    setUser(user);
    localStorage.setItem("user", JSON.stringify(user));
    setIsAuthenticated(true);
  };

  const logout = () => {
    setUser(null);
    localStorage.removeItem("user");
    setIsAuthenticated(false);
  };

  return (
    <AuthContext.Provider value={{
      isAuthenticated,
      user,
      login,
      logout,
    }}>
      {children}
    </AuthContext.Provider>
  );
}