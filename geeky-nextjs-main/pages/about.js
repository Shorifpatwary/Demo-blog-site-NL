import About from "@layouts/About";
import Base from "@layouts/Baseof";
import aboutJson from "@config/pages/about.json";

import cutStringToWords from "@lib/cutStringToWords";

// for all regular pages
const aboutPage = ({ aboutData }) => {
  return (
    <Base
      title={aboutData.title}
      description={
        aboutData.description
          ? aboutData.description
          : cutStringToWords(aboutData.content, 30)
      }
      meta_title={aboutData.meta_title}
      image={aboutData.image}
      noindex={aboutData.noindex}
      canonical={aboutData.canonical}
    >
      <About data={aboutData} />
    </Base>
  );
};
export default aboutPage;

// for regular page data
export const getStaticProps = async () => {
  return {
    props: {
      aboutData: aboutJson,
    },
  };
};
