import React from 'react';
import {
  useRoutes,
} from "react-router-dom";

import Router from './routes/Router';

function App() {

  const routes = useRoutes(Router)

  return (
    <React.Fragment>
      {routes}
    </React.Fragment>
  );
}

export default App;
