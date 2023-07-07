import NotFound from "@layouts/404";
import Base from "@layouts/Baseof";
import notFoundJson from "@config/pages/404.json";

const notFound = ({ data }) => {
  return (
    <Base>
      <NotFound data={data} />
    </Base>
  );
};

// get 404 page data
export const getStaticProps = async () => {
  return {
    props: {
      data: notFoundJson,
    },
  };
};

export default notFound;
