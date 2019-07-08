
import guest from '../routes/guest';
import manager from '../routes/Manager';
import pcoord from '../routes/Projcoord';

let routesFile = [];

const routes = routesFile.concat(
    guest,
    manager,
    pcoord
);

export default routes;