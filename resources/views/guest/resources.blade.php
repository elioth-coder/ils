<x-layout>
    <x-slot:head>
        <style>
            .card {
                min-height: 100%;
            }

            .card-img-top {
                height: 200px;
                object-fit: contain;
                background-color: #f8f9fa;
            }

            .card-text {
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 4;
                -webkit-box-orient: vertical;
            }

            .card-body {
                display: flex;
                flex-direction: column;
            }

            .btn {
                margin-top: auto;
            }
        </style>
    </x-slot:head>
    <x-header-guest />
    <main class="d-flex flex-column align-items-center justify-content-center w-100 bg-success-subtle">
        <h2 class="my-4">Open Educational Resources (OER)</h2>
        <div class="container d-flex py-2">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/arxiv.png" class="card-img-top" alt="arXiv">
                        <div class="card-body">
                            <p class="card-text">
                                arXiv is a free distribution service and an open-access archive for 1,705,224 scholarly
                                articles in the fields of physics, mathematics, computer science, and more.
                            </p>
                            <a href="https://arxiv.org/" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/asean.png" class="card-img-top" alt="ASEAN Digital Library">
                        <div class="card-body">
                            <p class="card-text">
                                National Libraries from ASEAN countries offer a wealth of library resources, including
                                books, manuscripts, maps, and audio recordings.
                            </p>
                            <a href="https://www.aseanlibrary.org/" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/base.png" class="card-img-top" alt="BASE">
                        <div class="card-body">
                            <p class="card-text">
                                BASE provides access to over 240 million documents from 8,000 providers, with many
                                open-access documents available.
                            </p>
                            <a href="https://www.base-search.net/" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/bentham.png" class="card-img-top" alt="Bentham">
                        <div class="card-body">
                            <p class="card-text">
                                BENTHAM Open publishes a number of peer-reviewed, open access journals. These free-to-view
                                online journals cover all major disciplines of science, medicine, technology, and social
                                sciences.
                            </p>
                            <a href="https://benthamopenarchives.com/" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/bmc.png" class="card-img-top" alt="BMC">
                        <div class="card-body">
                            <p class="card-text">
                                BMC has an evolving portfolio of some 300 peer-reviewed journals, sharing discoveries from
                                research communities in science, technology, engineering, and medicine.
                            </p>
                            <a href="https://www.biomedcentral.com/" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/bookboon.png" class="card-img-top" alt="Bookboon">
                        <div class="card-body">
                            <p class="card-text">
                                Providing researchers with access to journals, books, series, and reference works.
                            </p>
                            <a href="https://bookboon.com/" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/cog.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                An electronic archive for self-archive papers in any area of Psychology, Neuroscience, and
                                Linguistics, and many areas of Computer Science, Philosophy, Biology, Medicine, Anthropology
                                as well as any other portions of the physical, social and mathematical sciences that are
                                pertinent to the study of cognition </p>
                            <a href="https://web-archive.southampton.ac.uk/cogprints.org/"
                                class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/core.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                "CORE harvests research papers from such as institutional and subject repositories, and open
                                access and hybrid journals. CORE currently contains 217,676,617 open access articles
                                collected from 10,323 data providers around the world." </p>
                            <a href="https://core.ac.uk/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/credo.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Credo Reference is an information skills solutions provider that serves libraries worldwide.
                                We build platforms and instructional materials that enable the flexible configuration of
                                content, technology and services for the purpose of connecting learners, faculty and
                                teachers, librarians and publishers. Credo promotes knowledge building, problem solving and
                                critical thinking to give people the information skills necessary for success throughout
                                their academic, professional and personal lives. </p>
                            <a href="https://iden5.infobase.com/account/login?returnUrl=%2Fconnect%2Fauthorize%2Fcallback%3Fclient_id%3Dinfobase_auth%26scope%3DcustomAPI.read%2520openid%2520profile%26response_type%3Dcode%26redirect_uri%3Dhttps%253A%252F%252Fsearch.credoreference.com%252Fapi%252Fauth%252Fcallback%252Finfobase-identity-server%26app%3DCredo076%26base64ReturnUrl%3DaHR0cHM6Ly9zZWFyY2guY3JlZG9yZWZlcmVuY2UuY29tL2FwaS9hdXRoL2NhbGxiYWNrL2luZm9iYXNlLWlkZW50aXR5LXNlcnZlcg%253D%253D%26base64OriginUrl%3DaHR0cHM6Ly9zZWFyY2guY3JlZG9yZWZlcmVuY2UuY29tLw%253D%253D%26proxied%3Dfalse%26ip%3D115.147.15.254%26referer%3Dhttps%253A%252F%252Flibrary.neust.edu.ph%252F"
                                class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/dimensions.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Dimensions is a next-generation linked research information system that makes it easier to
                                find and access the most relevant information, analyze the academic and broader outcomes of
                                research, and gather insights to inform future strategy. </p>
                            <a href="https://app.dimensions.ai/auth/base/landing?redirect=%2Fdiscover%2Fpublication"
                                class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/dlc.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                The Digital Library of the Commons (DLC) is a gateway to the international literature on the
                                commons. The DLC provides free and open access to full-text articles, papers, and
                                dissertations. This site contains an author-submission portal; an Image Database; the
                                Comprehensive Bibliography of the Commons; a Keyword Thesaurus, and links to relevant
                                reference sources on the study of the commons. </p>
                            <a href="https://dlc.dlib.indiana.edu/dlc/home" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/doab.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                DOAB is a community-driven discovery service that indexes and provides access to scholarly,
                                peer-reviewed open access books and helps users to find trusted open access book publishers.
                                All DOAB services are free of charge and all data is freely available. </p>
                            <a href="https://www.doabooks.org/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/doaj.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                DOAJ is a community-curated online directory that indexes and provides access to high
                                quality, open access, peer-reviewed journals. All DOAJ services are free of charge including
                                being indexed. All data is freely available.</p>
                            <a href="https://doaj.org/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/dost.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                The DOST is the “provider of world-class scientific, technological and innovative solutions
                                that will lead to higher productivity and better quality of life.”</p>
                            <a href="https://www.dost.gov.ph/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/ebsco.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Growing Selection of Thousands of Open Access (OA), DRM-Free E-Books</p>
                            <a href="https://more.ebsco.com/ebooks-open-access-2021.html?fbclid=IwAR0YkOkeYjJH6WkJVk5YEWr1oPW_ZP87V7vBDI2ScwwAd2Lyqh8Z8bI2y44"
                                class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/ebsco2.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                OpenDissertations.org is a collaboration between EBSCO and BiblioLabs that brings an
                                innovative approach to increasing traffic and discoverability of ETD research.</p>
                            <a href="https://more.ebsco.com/ebooks-open-access-2021.html?fbclid=IwAR0YkOkeYjJH6WkJVk5YEWr1oPW_ZP87V7vBDI2ScwwAd2Lyqh8Z8bI2y44"
                                class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/elsevier.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Elsevier is a leader in information and analytics for customers across the global research
                                and health ecosystems </p>
                            <a href="https://www.elsevier.com/open-access/open-access-journals"
                                class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/encyclo.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                As the Internet's premier collection of online encyclopedias, Encyclopedia.com provides you
                                reference entries from credible, published sources like Oxford University Press and Columbia
                                Encyclopedia.</p>
                            <a href="https://www.encyclopedia.com/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/eric.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                ERIC is a comprehensive, easy-to-use, searchable, Internet-based bibliographic and full-text
                                database of education research and information.</p>
                            <a href="https://eric.ed.gov/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/etands.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Educational Technology & Society (ET&S) is an open-access academic journal published
                                quarterly (January, April, July, and October) since October 1998.ET&S has achieved its
                                purposes of providing an international forum for open access scientific dialogue for
                                developers, educators and researchers to foster the development of research in educational
                                technology.</p>
                            <a href="https://www.j-ets.net/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/freebook.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Freebookcentre.net contains links to thousands of free online technical books. Which Include
                                core computer science, networking, programming languages, Systems Programming books, Linux
                                books and many more</p>
                            <a href="https://www.freebookcentre.net/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/freebookspot.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                A free e-books links library where you can find and download free books in almost any
                                category. They have lots of links to free eBooks in more than 90 categories </p>
                            <a href="https://freebookspot.pro/Default" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/freecomputerbooks.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                a directory of Hyperlinks to free ebooks, tutorials, and lecture notes, etc, all over the
                                world. It is basically a free service to the communities with the focus on Information
                                Technologies, Computer Science, Mathematics, etc. </p>
                            <a href="https://freecomputerbooks.com/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>




                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/freeebook.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                A source for free eBook downloads, eBook resources & eBook authors. Read & download eBooks
                                for Free.</p>
                            <a href="https://www.free-ebooks.net/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>




                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/freemedicaljournal.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                The Free Medical Journals Site was created to promote the free availability of full text
                                medical journals on the Internet </p>
                            <a href="http://m.freemedicaljournals.com/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>



                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/gale.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Gale offers a variety of resources for education, lifelong learning, and academic research.
                                Whether you are looking for peer-reviewed articles; full-text magazines, newspapers, and
                                eBooks; primary source documents; and videos or podcasts, Gale puts the right vetted content
                                and tools at your fingertips! </p>
                            <a href="https://link.gale.com/apps/menu?userGroupName=phneust&prodId=MENU"
                                class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>





                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/freetech.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                This site lists free online computer science, engineering and programming books, textbooks
                                and lecture notes, all of which are legally and freely available over the Internet. </p>
                            <a href="https://www.freetechbooks.com/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>






                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/globeelibrary.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                The Globe eLibrary is both a web platform and mobile application that provides students and
                                educators with free and quick access to digital storybooks and eLearning videos. It features
                                age-appropriate and engaging educational resources tailored to children and young adults in
                                the Philippines. Users can enjoy free access to hundreds of digital titles and video content
                                through their mobile phones, tablet, laptop, and desktop computer</p>
                            <a href="https://globeelibrary.ph/lander" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>






                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/getfreeboos.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                A site that brings both authors and readers into the world of free legal eBooks </p>
                            <a href="https://www.getfreeebooks.com/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>





                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/ijoc.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                The International Journal of Communication is an online, multi-media, academic journal that
                                adheres to the highest standards of peer review and engages established and emerging
                                scholars from anywhere in the world.</p>
                            <a href="https://ijoc.org/index.php/ijoc" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>




                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/infocomp.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                INFOCOMP is a Computer Science Journal with the mission to publish original research
                                articles that provide significant improvements, theoretical and/or application case studies,
                                from research ideas and application results. </p>
                            <a href="https://infocomp.dcc.ufla.br/index.php/infocomp" class="btn btn-primary mt-auto">Learn
                                More</a>
                        </div>
                    </div>
                </div>






                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/informit.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Informit is a leading destination for enriching knowledge, connecting and educating the
                                global community by sharing credible, peer-reviewed, scholarly research from Australasia and
                                around the world. </p>
                            <a href="https://search.informit.org/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>





                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/internetarchive.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Internet Archive is a non-profit library of millions of free books, movies, software, music,
                                websites, and more. </p>
                            <a href="https://archive.org/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>





                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/isj.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                International Scientific Journal publishes high quality peer-reviewed scholarly journals.
                                All papers published are accessible online and available in hard copy on Amazon. </p>
                            <a href="https://www.scientific-journal.com/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>





                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/iti.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Information Technologies & International Development focuses on the intersection of
                                information and communication technologies (ICT) with economic and social development. It is
                                a peer-reviewed, international, multidisciplinary quarterly designed for researchers and
                                practitioners from the engineering and social sciences, technologists, policy makers, and
                                development specialists </p>
                            <a href="https://itidjournal.org/index.php/itid/index.html"
                                class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>






                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/jci.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                The Journal of Clinical Investigation is a premier venue for discoveries in basic and
                                clinical biomedical science that will advance the practice of medicine. </p>
                            <a href="https://www.jci.org/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>






                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/jheoe.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                The Journal of Higher Education Outreach and Engagement is to serve as the premier
                                peer-reviewed, interdisciplinary journal to advance theory and practice related to all forms
                                of outreach and engagement between higher education institutions and communities </p>
                            <a href="https://openjournals.libs.uga.edu/jheoe" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>






                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/apl.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                The Johns Hopkins APL Technical Digest is an unclassified technical journal published
                                quarterly by the Applied Physics Laboratory. The objective of the publication is to
                                communicate the work performed at the Laboratory to its sponsors and to the scientific and
                                engineering communities, defense establishment, academia, and industry. </p>
                            <a href="https://secwww.jhuapl.edu/techdigest" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>





                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/journalofhuman.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                The Journal of Human Kinetics is an open access interdisciplinary periodical offering the
                                latest research in the science of human movement studies. This comprehensive professional
                                journal features articles and research notes encompassing such topic areas as: Kinesiology,
                                Exercise Physiology and Nutrition, Sports Training as well as Behavioural Sciences in Sport,
                                yet especially considering elite and competitive aspects of sport </p>
                            <a href="https://johk.pl/index.html/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>





                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/journalsforfree.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Journals for Free is a directory of open access journals and journals with some kind of open
                                access to their materials. Journals for Free has now more that 17,000 open access journals,
                                what makes it the world's most complete list of its kind. </p>
                            <a href="http://www.journals4free.com/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>






                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/jstor.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                JSTOR provides access to more than 12 million journal articles, books, images, and primary
                                sources in 75 disciplines. </p>
                            <a href="https://www.jstor.org/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>






                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/libretext.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            LibreCommons hosts curated Open Educational Resources from all 14 LibreTexts libraries in one
                            convenient location. LibreCommons, the LibreTexts Libraries, and all of the resources are
                            accessible to everyone via the internet, completely free. </p>
                            <a href="https://commons.libretexts.org/?fbclid=IwAR1C4LrGrA-Q4u1IbE-39S_PimmV8swboEQ16WRBd4xtsE8c4zBCwvImbco"
                                class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>






                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/nlp.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                National Library of the Philippines acts as central node of the country's public library
                                system through the Public Libraries Division. It is responsible in linking public libraries
                                particularly in terms of information system and service orientation. </p>
                            <a href="https://web.nlp.gov.ph/nlp/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/nlm.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                The National Center for Biotechnology Information advances science and health by providing
                                access to biomedical and genomic information. </p>
                            <a href="https://www.ncbi.nlm.nih.gov/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>





                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/ncca.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                The National Commission for Culture and the Arts (NCCA), Philippines is the overall policy
                                making body, coordinating, and grants giving agency for the preservation, development and
                                promotion of Philippine arts and culture </p>
                            <a href="https://ncca.gov.ph/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>





                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/mdpi.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                A pioneer in scholarly, open access publishing, MDPI has supported academic communities
                                since 1996. Based in Basel, Switzerland, MDPI has the mission to foster open scientific
                                exchange in all forms, across all disciplines. </p>
                            <a href="https://www.mdpi.com/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>






                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/openaccess.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Open Access eBooks is an international publisher of eBooks. Open Access eBooks covers
                                different disciplines of science, technology and medicine. Each eBook contains around 6 or 7
                                book chapters providing the latest information to the readers</p>
                            <a href="https://www.openaccessebooks.com/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>






                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/openaccessjournal.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                It aims of providing a platform for "Open Access" to the research information pertaining to
                                diversified fields of Science and technology. It publishes scholarly journals that can be
                                easily accessed online without paying any subscription charges. It also organize 3000+
                                International conferences across the globe, where knowledge transfer takes place through
                                debates, round table discussions, poster presentations, workshops, symposia and exhibitions.
                            </p>
                            <a href="https://www.omicsonline.org/open-access-journals-list.php"
                                class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>





                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/ourworld.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Our World in Data is about Research and data to make progress against the world’s largest
                                problems. </p>
                            <a href="https://ourworldindata.org/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>





                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/paperity.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Paperity gives readers easy and unconstrained access to thousands of journals from hundreds
                                of disciplines, in one central location.</p>
                            <a href="https://paperity.org/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>





                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/pdfdrive.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                PDF Drive is a free search engine which allows you to search, preview and download millions
                                of PDF files into your devices.PDF Drive library stays up-to-date, while continuously
                                growing and offering you an enormous database to search. </p>
                            <a href="https://www.pdfdrive.com/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>





                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/phlched.jpg" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                A web application that contains higher education course materials in text, media and other
                                digital assets that are useful for teaching, learning and research purposes. </p>
                            <a href="https://phlconnect.ched.gov.ph/home" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/pjs.jpg" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                This is the online version of the Philippine Journal of Science (Philipp J Sci or PJS)—an
                                open-access, single-blind peer-reviewed journal on natural sciences, engineering,
                                mathematics, and social sciences. PJS is published by the Department of Science and
                                Technology and managed by Science and Technology Information Institute. </p>
                            <a href="https://philjournalsci.dost.gov.ph/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/pshev.jpg" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Philippine Studies: Historical and Ethnographic Viewpoints is an internationally refereed
                                journal that publishes scholarly articles and other materials on the history of the
                                Philippines and its peoples, both in the homeland and overseas. </p>
                            <a href="https://philippinestudies.net/ojs/index.php/ps" class="btn btn-primary mt-auto">Learn
                                More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/philrice.jpg" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                The PhilRice Library is a special library dedicated to the collection, organization,
                                maintenance, storage and retrieval of Filipiniana rice literature. It is also the depository
                                of PhilRice publications. Our Library renders services benefiting the Filipino rice
                                scientists, researchers, educators, students, extension workers, farmers and other
                                stakeholders. </p>
                            <a href="https://www.philrice.gov.ph/libraryweb/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/plos.jpg" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                PLOS is a nonprofit, Open Access publisher empowering researchers to accelerate progress in
                                science and medicine by leading a transformation in research communication.</p>
                            <a href="https://plos.org/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/projectgutenberg.jpg" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Project Gutenberg is an online library of free eBooks. Project Gutenberg was the first
                                provider of free electronic books, or eBooks. Michael Hart, founder of Project Gutenberg,
                                invented eBooks in 1971 and his memory continues to inspire the creation of eBooks and
                                related content today. </p>
                            <a href="https://www.gutenberg.org/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/projectmuse.jpg" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Project MUSE is a leading provider of digital humanities and social science content for the
                                scholarly community around the world.Project MUSE has been the trusted and reliable source
                                of complete, full-text versions of scholarly journals from many of the world's leading
                                universities and scholarly societies. Currently, Project MUSE has over 800 journals from 125
                                publishers and offers over 80,000 books from more than 140 presses. All books are fully
                                integrated with Project MUSE's scholarly journal content, with collection and single title
                                purchasing, subscription and evidence-based acquisition models available. MUSE also offers
                                over 4000 open access books on the platform. </p>
                            <a href="https://muse.jhu.edu/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/repec.jpg" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                RePEc (Research Papers in Economics) is a collaborative effort of hundreds of volunteers in
                                102 countries to enhance the dissemination of research in Economics and related sciences.
                            </p>
                            <a href="http://repec.org/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/sagejournals.jpg" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                The natural home for leading authors, editors and societies. Publishing more than 1,000
                                journals, from a wide range of disciplines, SAGE is here to meet your needs. </p>
                            <a href="https://journals.sagepub.com/home/lal" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/sap.jpg" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Scientific & Academic Publishing (SAP) is an Open-Access publisher of journals covering a
                                wide range of academic disciplines. SAP serves the world's research and scholarly
                                communities, and aims to be one of the largest publishers for professional and scholarly
                                societies. SAP's journals maintain the highest standards of peer review, with some
                                internationally-recognized editors serving on the editorial boards of SAP's journals.</p>
                            <a href="http://www.sapub.org/Journal/index.aspx" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/scientificresearch.jpg" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Scientific Research Publishing (SCIRP) is one of the largest Open Access journal publishers.
                                It is currently publishing more than 200 open access, online, peer-reviewed journals
                                covering a wide range of academic disciplines. SCIRP serves the worldwide academic
                                communities and contributes to the progress and application of science with its publication.
                            </p>
                            <a href="https://www.scirp.org/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/seameo.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                MT4T is a teacher resource kit that promotes the use mobile technology in Southeast Asian
                                educational settings. The kit provides a basic guide in using mobile devices, such as smart
                                phones and tablets and their accompanying applications, as tools for teaching and learning
                                in the classroom and for teacher’s personal and professional development.</p>
                            <a href="https://www.seameo-innotech.org/mt4t/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/slj.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                School Library Journal is the premiere publication for librarians and information
                                specialists who work with children and teens. A source of quality journalism and reviews for
                                more than 60 years, SLJ produces award-winning features and news coverage on: literacy, best
                                practices, technology, education policy and other issues of interest to the school library
                                and greater educator community. SLJ evaluate a broad range of resources, from books and
                                digital content to databases, in 6000+ reviews published annually. </p>
                            <a href="https://www.slj.com/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/springeropen.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                SpringerOpen is Springer's portfolio of fully open access journals and books, covering all
                                areas of science. The entire content published with SpringerOpen is freely accessible online
                                immediately upon publication. SpringerOpen views open access to research as essential in
                                order to ensure the rapid and efficient communication of research findings. </p>
                            <a href="https://www.springeropen.com/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/ssrn.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                SSRN is devoted to the rapid worldwide dissemination of research and is composed of a number
                                of specialized research networks. SSRN´s eLibrary provides 1,163,332 research papers from
                                995,066 researchers in more than 65 disciplines. </p>
                            <a href="https://www.ssrn.com/index.cfm/en/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/theonlinebookspage.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                The Online Books Page is a website that facilitates access to books that are freely readable
                                over the Internet. It also aims to encourage the development of such online books, for the
                                benefit and edification of all. </p>
                            <a href="https://onlinebooks.library.upenn.edu/index.html" class="btn btn-primary mt-auto">Learn
                                More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/ufdc.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                The University of Florida Digital Collections (UFDC) hosts many outstanding digital
                                collections, containing millions of pages, covering tens of thousands of subjects in rare
                                books, manuscripts, global and generic maps, children's literature, newspapers, theses and
                                dissertations, data sets, photographs, oral histories, and more for permanent access and
                                preservation. Through UFDC, users have free and Open Access to full unique and rare
                                materials held by the University of Florida and partner institutions. </p>
                            <a href="https://ufdc.ufl.edu/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/umresearch.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                UM Research Repository is the Universiti Malaya’s perpetual, accessible and growing
                                collection of research work which includes peer-reviewed articles, conferences and working
                                papers representing our rich intellectual community. It has been established to provide a
                                deposit service for the academic staff and researchers. It is an initiative of the Digital
                                Scholarship and Information Commons. Where possible the details of each item described in
                                the archive will include a link to a freely available electronic copy of the full text or
                                other electronic documentation of the research output. </p>
                            <a href="https://eprints.um.edu.my/2051/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/unesco.jpg" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                The UNESCO Digital Library is the repository of UNESCO’s institutional memory and a source
                                of high-quality information on UNESCO activities (in education, natural sciences, social and
                                human sciences, culture, and communication and information), with more than 350,000
                                documents dating back to 1945. It includes the collections of the UNESCO Library and several
                                documentation centres in UNESCO’s Field Offices and Institutes, as well as the UNESCO
                                Archives. The essential purpose of the UNESCO Digital Library is to share knowledge and to
                                transmit it to future generations. </p>
                            <a href="https://unesdoc.unesco.org/.../N-e587e34c-d167-4f2a-bac3?fbclid=IwAR0tRcfBaKDjejpgKA0nS40xemiqBbiLAMuUifro-btTDLpMQCmJilYHlIk"
                                class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>



                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/updiliman.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                A free online service exclusively offered to U.P. Diliman journals. It aims to gather all
                                the U.P. Diliman journals in a single repository; widen their dissemination and visibility
                                online; and provide journal editors with a convenient means of implementing the editorial
                                process.
                            </p>
                            <a href="https://upd.edu.ph/" class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>




                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <img src="{{ asset('images/resources') }}/wiley.png" class="card-img-top" alt="New Resource">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">
                                Fully gold open access journals are authoritative and peer-reviewed, published across most
                                research disciplines open access journals. All research articles published in Wiley Open
                                Access journals are immediately freely available to read, download and share. The fully open
                                access journals are published in collaboration with authoritative journals and societies as
                                well as supported by internationally renowned editorial board members. </p>
                            <a href="https://authorservices.wiley.com/author-resources/Journal-Authors/open-access/index.html"
                                class="btn btn-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>
    <x-footer />
</x-layout>
