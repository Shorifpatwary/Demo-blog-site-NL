import NotFound from "@layouts/404";
import About from "@layouts/About";
import Base from "@layouts/Baseof";
import Contact from "@layouts/Contact";
// import Default from "@layouts/Default";
import aboutJson from "@config/pages/about.json";
import contactJson from "@config/pages/contact.json";
import notFoundJson from "@config/pages/404.json";
import elementsJson from "@config/pages/elements.json";

// import { getRegularPage, getSinglePage } from "@lib/contentParser";

// for all regular pages
const RegularPages = ({
  notFoundData,
  aboutData,
  contactData,
  elementsData,
}) => {
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
      {layout === "404" ? (
        <NotFound data={notFoundData} />
      ) : layout === "about" ? (
        <About data={aboutData} />
      ) : layout === "contact" ? (
        <Contact data={contactData} />
      ) : // <Default data={data} />
      null}
    </Base>
  );
};
export default RegularPages;

// for regular page routes
// export const getStaticPaths = async () => {
//   const slugs = getSinglePage("content");
//   const paths = slugs.map((item) => ({
//     params: {
//       regular: item.slug,
//     },
//   }));

//   return {
//     paths,
//     fallback: false,
//   };
// };

// for regular page data
export const getServerSideProps = async ({ params }) => {
  const { regular } = params;
  return {
    props: {
      slug: regular,
      // data: allPages,
      notFoundData: notFoundJson,
      aboutData: aboutJson,
      contactData: contactJson,
      elementsData: elementsJson,
    },
  };
};

// for regular page data
// export const getStaticProps = async ({ params }) => {
//   const { regular } = params;
//   return {
//     props: {
//       slug: regular,
//       // data: allPages,
//       notFoundData: notFoundJson,
//       aboutData: aboutJson,
//       contactData: contactJson,
//       elementsData: elementsJson,
//     },
//   };
// };
