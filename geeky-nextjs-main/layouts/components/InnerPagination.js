import Link from "next/link";

const InnerPagination = ({ posts, date }) => {
  const lastIndex = posts.length - 1;
  const postIndex = posts.findIndex((post) => post.published_at == date);
  const next =
    postIndex == 0
      ? undefined
      : `${posts[postIndex - 1]?.id}/${posts[postIndex - 1]?.slug}`;
  const prev =
    postIndex == lastIndex
      ? undefined
      : `${posts[postIndex + 1]?.id}/${posts[postIndex + 1]?.slug}`;
  const prevButton = prev && (
    <Link href={prev} className={"btn btn-primary"}>
      Prev
    </Link>
  );
  const nextButton = next && (
    <Link href={next} className={"btn btn-primary"}>
      Next
    </Link>
  );

  return (
    <div className="row">
      <span className="col">{prevButton}</span>
      <span className="col-8" />
      <span className="col">{nextButton}</span>
    </div>
  );
};

export default InnerPagination;
