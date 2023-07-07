import { markdownify } from "@lib/utils/textConverter";
import shortcodes from "@shortcodes/all";
import { MDXRemote } from "next-mdx-remote";
import Image from "next/image";

const About = ({ data }) => {
  // const { frontmatter, mdxContent } = data;
  const { title, image, education, experience } = data;

  return (
    <section className="section mt-16">
      <div className="container text-center">
        {image && (
          <div className="mb-8">
            <Image
              src={image}
              width={1298}
              height={616}
              alt={title}
              className="rounded-lg"
              priority={true}
            />
          </div>
        )}
        {markdownify(title, "h1", "h1 text-left lg:text-[55px] mt-12")}

        <div className="content mb-4 mt-4 text-left">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi amet,
          ultrices scelerisue cras. Tincidunt hendrerit egestas venenatis risus
          sit nunc. Est esglit non in ipsum lect;aaus adipiscing et enim
          porttitor. Dui ultrices et volud eetpat nunc, turpis rutrum elit
          vestibululm ipsum. Arcu fringilla duis vitae mos dsdllis duicras
          interdum purus cursus massa metus. Acc umsan felaais, egsdvet nisi,
          viverra turpis fermentum sit suspf bafedfb ndisse fermentum
          consectetur. Facilisis feugiat trisique orci tempor sed masd fbsssa
          tristique ultrices sodales. Augue est sapien elementum facilisis. Enim
          tincidnt cras interdum purus ndisse. morbi quis nunc.
        </div>

        <div className="content mb-4 mt-4 text-left">
          Et dolor placerat tempus risus nunc urna, nunc a. Mattis viverra ut
          sapidaaen enim sed tortor. Mattis gravida fusce cras interdum purus
          cursus massa metus. Acc umsan felaais, eget nisi, viverra turpis
          fermentum sit suspf bafedfb ndisse. morbi quis nunc, at arcu quam
          facilisi. In in lacus aliquam dictum sagittis morbi odio. Et magnis
          cursus sem sed condimentum. Nibh non potenti ac amsdfet Tincidunt
          hendrerit egestas venenatis risus sit nunc. Est esglit non in ipsuasdm
          lect;aaus adipiscing et enim porttitor. Dui ultrices et volud eetpat
          nunc, turpis ndisse. morbi quis nunc, at arcu quam facilisi ndisse.
          morbi quis nunc, at arcu quam facilisi
        </div>

        <div className="row mt-24 text-left lg:flex-nowrap">
          <div className="lg:col-6 ">
            <div className="rounded border border-border p-6 dark:border-darkmode-border ">
              {markdownify(education.title, "h2", "section-title mb-12")}
              <div className="row">
                {education.degrees.map((degree, index) => (
                  <div className="mb-7 md:col-6" key={"degree-" + index}>
                    <h4 className="text-base lg:text-[25px]">
                      {degree.university}
                    </h4>
                    <p className="mt-2">{degree.content}</p>
                  </div>
                ))}
              </div>
            </div>
          </div>
          <div className="experience mt-10 lg:col-6 lg:mt-0">
            <div className="rounded border border-border p-6 dark:border-darkmode-border ">
              {markdownify(experience.title, "h2", "section-title mb-12")}
              <ul className="row">
                {experience?.list?.map((item, index) => (
                  <li
                    className="mb-5 text-lg font-bold text-dark lg:col-6 dark:text-darkmode-light"
                    key={"experience-" + index}
                  >
                    {item}
                  </li>
                ))}
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default About;
