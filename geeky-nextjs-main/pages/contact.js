import Base from "@layouts/Baseof";
import Contact from "@layouts/Contact";
import contactJson from "@config/pages/contact.json";

// for all regular pages
const RegularPages = ({
  contactData,
}) => {
  return (
    <Base
      title={contactData.title}
      description={
        contactData.description
          ? contactData.description
          : cutStringToWords(contactData.content, 30)
      }
      meta_title={contactData.meta_title}
      image={contactData.image}
      noindex={contactData.noindex}
      canonical={contactData.canonical}
    >
      <Contact data={contactData} />
    </Base>
  );
};
export default RegularPages;

// for regular page data
export const getStaticProps = async () => {
  return {
    props: {
      contactData: contactJson,
    },
  };
};
