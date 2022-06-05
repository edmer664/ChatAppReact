import { Home } from "../components/Home";


export const Router = [
  {
    path: '/',
    name: 'home',
    element: <Home/>,
  },
  {
    path: '/login'
  }

]

export default Router;