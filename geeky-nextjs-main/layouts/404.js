
const NotFound = ({ data }) => {
  return (
    <section className="section">
      <div className="container">
        <div className="flex h-[40vh] items-center justify-center">
          <div className="text-center">
            <h1 className="mb-4">{data.title}</h1>
            {/* {markdownify(content, "div", "content")} */}
            <h2 className=" heading-2 mb-4">{data.description}</h2>
          </div>
        </div>
      </div>
    </section>
  );
};

export default NotFound;
